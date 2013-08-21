<?php

/**
 * This is the model class for table "cms_email".
 *
 * The followings are the available columns in table 'cms_email':
 * @property string $id
 * @property string $from
 * @property string $to
 * @property string $cc
 * @property string $bcc
 * @property string $subject
 * @property string $body
 * @property string $headers
 * @property string $contentType
 * @property string $charset
 * @property string $created
 * @property integer $status
 */
class Mail extends SiteActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Mail the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'cms_email';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array_merge(parent::rules(), array(
			array('from, to, subject, body, headers, contentType, charset, created', 'required'),
			array('status', 'numerical', 'integerOnly'=>true),
			array('subject, contentType, charset', 'length', 'max'=>255),
			array('cc, bcc', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, from, to, cc, bcc, subject, body, headers, contentType, charset, created, status', 'safe', 'on'=>'search'),
		));
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'from' => 'From',
			'to' => 'To',
			'cc' => 'Cc',
			'bcc' => 'Bcc',
			'subject' => 'Subject',
			'body' => 'Body',
			'headers' => 'Headers',
			'contentType' => 'Content Type',
			'charset' => 'Charset',
			'created' => 'Created',
			'status' => 'Status',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->order='id DESC';
		$criteria->condition='deleted = 0';

		$criteria->compare('id',$this->id,true);
		$criteria->compare('from',$this->from,true);
		$criteria->compare('to',$this->to,true);
		$criteria->compare('cc',$this->cc,true);
		$criteria->compare('bcc',$this->bcc,true);
		$criteria->compare('subject',$this->subject,true);
		$criteria->compare('body',$this->body,true);
		$criteria->compare('headers',$this->headers,true);
		$criteria->compare('contentType',$this->contentType,true);
		$criteria->compare('charset',$this->charset,true);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    
    /**
     * This method is invoked after each record is instantiated by a find method.
     */
    public function afterFind()
    {
    
    	$this->created = date('m/d/Y',strtotime($this->created));
    	
	    return parent::afterFind();
    }
	
	/**
	 * This is invoked before the record is saved.
	 */
	public function beforeSave()
    {
	    if (parent::beforeSave())
	    {
            $this->created = date('Y-m-d',strtotime($this->created));
            
            return true;
		}
		else
			return false;
    }
	
	public function adminActions()
	{
		$currentStatus = $this->active==1?'Hide':'Show';
		$statusButton = $this->active==1?'warning':'success';
		
		$result =  CHtml::ajaxLink(
				        $currentStatus,
				        url('/CmsEmail/toggleActive'),
				        array(
			                'update'=>'.btn-hide-'.$this->id,
			                'method'=>'post',
			                'data'=> array( 'id' => $this->id ),
			                /*'success' => "function( data )
			                {
			                	alert( data );
			                }",*/
				        ),
				        array(
				        	'class'=>"btn btn-mini btn-{$statusButton} btn-hide-".$this->id,
				        )
					);	
		$result .= '&nbsp;&nbsp;'.l('Edit',array('/CmsEmail/update', 'id'=>$this->id), array('class'=>'btn btn-mini btn-primary'));
    	$result .= '&nbsp;&nbsp;'.l('Delete','', array('class'=>'btn btn-mini delete_dialog', 'data-url'=>url("/CmsEmail/delete",array('id'=>$this->id))));

    	return $result;
	}

    public static function sendEmail($data)
    {
        //log in database
        $mailLog = new Mail;
        $mailLog->from = $data['fromEmail'];
        $mailLog->to = json_encode($data['toEmail']);
        $mailLog->cc = $data['cc'];
        $mailLog->bcc = $data['bcc'];
        $mailLog->subject = $data['subject'];
        //$mailLog->body = $data['fromEmail'];
        $mailLog->status = '0';
        if(!$mailLog->save())
            return false;

        $mail = new YiiMailer();
        //use 'requestViewing' view from views/mail
        $mail->setView($data['view']);
        $mail->setData($data['mailData']);
        //render HTML mail, layout is set from config file or with $mail->setLayout('layoutName')
        $mail->render();

        $mail->IsSMTP(); // telling the class to use SMTP
        $mail->SMTPDebug  = 2;                     // enables SMTP debug information (for testing) // 1 = errors and messages // 2 = messages only
        $mail->SMTPAuth   = true;                  // enable SMTP authentication
        $mail->SMTPSecure = 'tls'; 				   // secure transfer enabled REQUIRED for GMail
        $mail->Host       = "smtp.gmail.com"; // sets the SMTP server
        $mail->Mailer 	  = "smtp";
        $mail->Port       = 587;                    // set the SMTP port for the GMAIL server
        $mail->Username   = "your-email@gmail.com"; // SMTP account username
        $mail->Password   = "your-password";        // SMTP account password

        //set properties as usually with PHPMailer
        $mail->From = $data['fromEmail'];
        $mail->FromName = $data['fromName'];
        $mail->Subject = $data['subject'];
        foreach($data['toEmail'] as $toEmail)
            $mail->AddAddress($toEmail);
        $mail->AddBCC($data['bcc']);
        //send
        if ($mail->Send()) {
            $mail->ClearAddresses();

            $mailLog->status = '0'; //update as sent in database
            if($mailLog->save())
                return true;
        } else
            return false;
    }
}