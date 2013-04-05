<?php
//https://github.com/Parmindertbl/yii-cmanymanyactiverecord
/*
Usage

If Category has:

'posts'=>array(self::MANY_MANY, 'Post', 'tbl_post_category(category_id, post_id)')

Create tbl_post_category (category_id, post_id) table and then

you can set relations by (with erasing old ones)

$model = Category::model()->findByPk(10);
$model->setRelationRecords('posts',array(1, 2, 3));

or you can add new relations (without deletions of old ones)

$model = Category::model()->findByPk(10);
$model->addRelationRecords('posts',array(1, 2, 3));

or you can remove some relations

$model = Category::model()->findByPk(10);
$model->removeRelationRecords('posts',array(1,2,3));

or if you need to save additional data in tbl_post_category (like user_id for example) you add relations with $additionalFields

$model = Category::model()->findByPk(10);
$model->addRelationRecords('posts',array(1, 2, 3), array('user_id' => Yii::app()->user->id));

Each of this method saves data to database, you don't need to save the model.
*/

class ManyManyActiveRecord extends CActiveRecord
{
	/* Auto load CAdvancedArBehavior class to all models */
	public function behaviors(){
    	return array( 
    		'CAdvancedArBehavior' => array(
    			'class' => 'application.extensions.CAdvancedArBehavior'
    		)
    	);
    }
    
	/**
	* @return array with table name and 2 keys of the related tables
	*/
        protected function verifyManyManyRelation($relation) {
            //check if primaryKey correct
            if (is_array($this->primaryKey))
                throw new CException('ManyManyActiveRecord can\'t work  with composite primary key');	    
            //check if relation correct
            //if (is_null($this->primaryKey))
                //throw new CException($relation->name.' error, primary key is null');
            //check if model have primaryKey
            //if ($this->isNewRecord)
                //throw new CException($relation->name.' error, save model first');
            //check if relation correct
            if (!is_object($relation) || get_class($relation) != 'CManyManyRelation')
                throw new CException($relation->name.' is not exist or not belongs to CManyManyRelation class');

            //match tablename(model key, foreign table key)
            preg_match_all('/([^()]*)\(([^,]*),([^)]*)\)/i', $relation->foreignKey, $matches);
            return $matches;
        }

	/**
	* Create tables relation records on ManyMany relation with deletion old ones
	* @param string $relationName the name of the relation, needs to be updated
	* @param array  $relationData array of related keys of second table to be connected with first table
	*/
        public function setRelationRecords($relationName, $relationData, $additionalFields = array(), $useTransaction = false)
        { 
        	if(!empty($relationData)) {
	            //get correct relation from model relation defenition
	            $relation = $this->getActiveRelation($relationName);
	
	            $matches = $this->verifyManyManyRelation($relation);
	
	            $table = $matches[1][0];
	            $this_key = $matches[2][0];
	            $another_key = $matches[3][0];
	            
	            if ($useTransaction)
	                $transaction = Yii::app()->db->beginTransaction();
	
	            try {
	                //execute delete old relations statement
	                $this->removeAllRelationRecords($relationName, $additionalFields);
	                /*$sql = "delete from {$table} WHERE $this_key = '{$this->primaryKey}'";
	                $command = Yii::app()->db->createCommand($sql);
	                $command->execute();*/

	                //execute insert new relations statement
	                if (count($additionalFields) > 0) {
	                    foreach($additionalFields as $key=>$value) {
	                        $keys[] = $key;
	                    }
	                    $insert_sql = "insert into {$table} ($this_key, $another_key, ".implode(',', $keys).") VALUES ";
	                }
	                else
	                    $insert_sql = "insert into {$table} ($this_key, $another_key) VALUES ";
	                    
	                $com = Yii::app()->db->createCommand();
	                $c = count($relationData);
	                $sql = array();
	                for ($i = 0; $i<$c; $i++) {
	                    if (count($additionalFields) > 0) {
	                        foreach($additionalFields as $key=>$value) {
	                            $values[] = $value;
	                        } 
	                        $sql[] = '('.$this->primaryKey.', '.$relationData[$i].", '".implode("', '", $values)."')";
	                    }
	                    else
	                         $sql[] = '('.$this->primaryKey.', '.$relationData[$i].')';
	                    //executes insert each 1000 rows or last time
	                    if (($i+1 % 1000) == 0 || $i == $c-1) {
	                        $com->setText($insert_sql.implode(', ', $sql));
	                        $com->execute();
	                        $com = Yii::app()->db->createCommand();
	                        $sql = array();
	                    }
	                    $values=null;
	                }
	                if ($useTransaction)
	                    $transaction->commit();
	            }
	            catch(Exception $e) {
	                if ($useTransaction)
	                    $transaction->rollback();
	                throw new CException($e->getMessage());
	            }
            } else {
	            $this->removeAllRelationRecords($relationName, $additionalFields);
            }
        }
	
	/**
	* Create new tables relation records on ManyMany relation without deletion old ones
	* @param string     $relationName the name of the relation, needs to be updated
	* @param array	    $relationData array of related keys of second table to be connected with first table
	*/
        public function addRelationRecords($relationName, $relationData, $additionalFields = array())
        {
            //get correct relation from model relation defenition
            $relation = $this->getActiveRelation($relationName);

            $matches = $this->verifyManyManyRelation($relation);

            $table = $matches[1][0];
            $this_key = $matches[2][0];
            $another_key = $matches[3][0];

            //execute insert new relations statement
            if (count($additionalFields) > 0) {
				foreach($additionalFields as $key=>$value) {
				    $keys[] = $key;
				}
	            $insert_sql = "insert into {$table} ($this_key, $another_key, ".implode(',', $keys).") VALUES ";
		    }
            else
                $insert_sql = "insert into {$table} ($this_key, $another_key) VALUES ";
            $com = Yii::app()->db->createCommand();
            $c = count($relationData);
            $sql = array();
            for ($i = 0; $i<$c; $i++) {
                if (count($additionalFields) > 0) {
				    foreach($additionalFields as $key=>$value) {
						$values[] = $value;
				    }
		                    $sql[] = '('.$this->primaryKey.', '.$relationData[$i].", '".implode("', '", $values)."')";
				}
                else
                    $sql[] = '('.$this->primaryKey.', '.$relationData[$i].')';
                //executes insert each 1000 rows or last time
                if (($i+1 % 1000) == 0 || $i == $c-1) {
                    $com->setText($insert_sql.implode(', ', $sql));
                    $com->execute();
                    $sql = array();
                }
            }
        }

        /**
	* Remove tables relation records on ManyMany relation
	* @param string $relationName the name of the relation, needs to be updated
	* @param int	$keys array of keys to remove
	*/
        public function removeRelationRecords($relationName, $keys)
        {
            //get correct relation from model relation defenition
            $relation = $this->getActiveRelation($relationName);

            $matches = $this->verifyManyManyRelation($relation);

            $table = $matches[1][0];
            $this_key = $matches[2][0];
            $another_key = $matches[3][0];

            //execute delete relation statement
            $sql = "delete from {$table} WHERE $this_key = '{$this->primaryKey}' AND $another_key IN (".implode(',', $keys).")";
            $command = Yii::app()->db->createCommand($sql);
            $command->execute();
        }	
        
        private function removeAllRelationRecords($relationName, $additionalFields = array())
        {
            //get correct relation from model relation defenition
            $relation = $this->getActiveRelation($relationName);

            $matches = $this->verifyManyManyRelation($relation);

            $table = $matches[1][0];
            $this_key = $matches[2][0];
            $another_key = $matches[3][0];

            //execute delete relation statement
            if (!empty($additionalFields)) {
            	$fields = '';
			    foreach($additionalFields as $key=>$value) {
					$fields .= " AND $key = '{$value}'";//$key = $value;
			    }
	            
            	$sql = "delete from {$table} WHERE $this_key = '{$this->primaryKey}' $fields"; 
            } else {
	        	$sql = "delete from {$table} WHERE $this_key = '{$this->primaryKey}'";  
            }
            
            $command = Yii::app()->db->createCommand($sql);
            $command->execute();
        }
}
?>