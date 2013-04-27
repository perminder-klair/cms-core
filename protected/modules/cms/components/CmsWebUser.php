<?php

/*
// for normal content
if(Yii::app()->user->isAdmin())
     echo 'Is administrator';
 
// for CMenus
$this->widget('zii.widgets.CMenu',array(
    array('label'=>'Categories',
           'url'=>array('/category/index'),
           'visible'=>(Yii::app()->user->isAdmin()),
     //... More stuff
     //...
 
// for data chuncks
<?php if(Yii::app()->user->isAdmin():?>
<b>My HTML</b>
<?php endif;?>
 
// for access rules
return array(
      array('allow', 
        'actions'=>array('create','delete','update'),
        'expression'=>'$user->isAdmin()'
      ),
// ...
*/

class CmsWebUser extends CWebUser{
 
    protected $_model;
 
    function isAdmin(){ 
    	if(Yii::app()->user->isGuest)
    		return false;
    		
        $user = $this->loadUser();
        /*if ($user->level==1)
        	return true; //return $user->level==CmsLookup::item('UserStatus', $user->level); //LevelLookUp::ADMIN
        return false;*/
        
        if (($user->getUserRole()=='admin') || ($user->getUserRole()=='super'))
        	return true;
        return false;
    }

    /**
     * get details from user model
     * use it: Yii::app()->user->getDetails()->email
     */
    public function getDetails()
    {
        if($user = $this->loadUser())
        	return $user;
    }
 
    // Load user model.
    protected function loadUser()
    {
        if ( $this->_model === null ) {
                $this->_model = CmsUser::model()->findByPk( Yii::app()->user->id );
        }
        return $this->_model;
    }
}