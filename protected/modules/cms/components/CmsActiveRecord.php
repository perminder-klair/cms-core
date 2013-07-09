<?php
/**
 * Cms base active record class that provides various base functionality.
 * All cms active records should be extended from this class.
 */
Yii::import('application.modules.cms.components.ManyManyActiveRecord');
 
class CmsActiveRecord extends ManyManyActiveRecord
{
        /**
         * @return array the default scope.
         */
        public function defaultScope()
        {
                $scope = parent::defaultScope();

                /*$condition='deleted=0';
                if (isset($scope['condition']))
                	$scope['condition'] .= ' AND ' . $condition;
                else
                	$scope['condition'] = $condition;*/
                
                return $scope;
        }

        /**
         * Actions to be taken before saving the record.
         * @return boolean whether the record can be saved
         */
        public function beforeSave()
        {
                if (parent::beforeSave())
                {
                        $now = date('Y-m-d H:i:s', time());
                        if (Yii::app() instanceof CConsoleApplication) {
                        	$userId = 1;
                        } else {
	                        $userId = Yii::app()->user->id;
                        }

                        if ($this->isNewRecord)
                        {
                                // We are creating a new record.
                                if ($this->hasAttribute('created'))
                                    	$this->created = $now;
                                        
                                if ($this->hasAttribute('modified'))
                                		$this->modified = $now;
                                		
                                if ($this->hasAttribute('updated'))
                                		$this->updated = $now;

                                if ($this->hasAttribute('author_id') && $userId !== null)
                                        $this->author_id = $userId;
                                        
                                if ($this->hasAttribute('deleted'))
                                		$this->deleted = 0;
                                		
                                if ($this->hasAttribute('active'))
                                		$this->active = 1;
                        }
                        else
                        {
                                // We are updating an existing record.
                                if ($this->hasAttribute('modified'))
                                        $this->modified = $now;
                                        
                                if ($this->hasAttribute('updated'))
                                		$this->updated = $now;

                                if ($this->hasAttribute('modifierId') && $userId !== null)
                                        $this->modifierId = $userId;
                        }

                        return true;
                }
                else
                        return false;
        }

        /**
         * Actions to be taken before calling delete.
         * @param boolean $soft indicates whether to perform a "soft" delete
         * @return boolean whether the record can be deleted
         */
        public function beforeDelete($soft = null)
        {
                if (parent::beforeDelete() && $soft && $this->hasAttribute('deleted'))
                {
                        $this->deleted = 1;
                        $this->save(false);
                        return false;
                }
                else
                        return true;
        }

        /**
         * Deletes the row corresponding to this active record.
         * @param boolean $soft indicates whether to perform a "soft" delete
         * @return boolean whether the deletion is successful
         * @throws CException if the record is new
         */
        public function delete($soft = true)
        {
                if (!$this->getIsNewRecord())
                {
                        Yii::trace(get_class($this) . '.delete()', 'CmsActiveRecord');

                        if ($this->beforeDelete($soft))
                        {
                                $result = $this->deleteByPk($this->getPrimaryKey()) > 0;
                                $this->afterDelete();
                                return $result;
                        }
                        else
                                return false;
                }
                else
                        throw new CDbException('The active record cannot be deleted because it is new.');
        }
}
