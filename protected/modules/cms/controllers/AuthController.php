<?php

class AuthController extends CmsController
{
	public function filters()
	{
		return array(
			array('cms.filters.AuthFilter'),
		);
	}
	
	/*
	 * Manage User Roles 
	 */
	public function actionRoles()
	{
		$this->layout = 'admin';
		
		$roles = CmsUser::getRolesAsListData();

		$this->render('roles/admin', array(
			'roles'=>$roles,
		));
	}
	
	public function actionUpdateRole($name)
	{
		$this->layout = 'admin';
		
		$formModel = new AddAuthItemForm();
		
		/* @var $am CAuthManager|AuthBehavior */
		$am = Yii::app()->getAuthManager();

		$item = $am->getAuthItem($name);

		if ($item === null)
			throw new CHttpException(404, Yii::t('AuthModule.main', 'Page not found.'));

		$model = new AuthItemForm('update');

		if (isset($_POST['AuthItemForm']))
		{
			$model->attributes = $_POST['AuthItemForm'];
			if ($model->validate())
			{
				$item->description = $model->description;

				$am->saveAuthItem($item);
				if ($am instanceof CPhpAuthManager)
					$am->save();

				$this->redirect(array('roles'));
			}
		}

		$model->name = $name;
		$model->description = $item->description;

		/*
		 *Get operations
		 */
		$allOperations = CmsUser::getAllOperations(); 
		
		
		if (isset($_POST['AddAuthItemForm']))
		{
			$formModel->attributes = $_POST['AddAuthItemForm'];
			if ($formModel->validate())
			{
				if (!$am->hasItemChild($name, $formModel->items))
				{
					$am->addItemChild($name, $formModel->items);
					if ($am instanceof CPhpAuthManager)
						$am->save();
				}
			}
		}

		$item = $am->getAuthItem($name);

		$ancestors = $am->getAncestors($name);

		$descendants = $am->getDescendants($name);
		
		$this->render('roles/update', array(
			'model' => $model,
			'allOperations' => $allOperations,
			'item' => $item,
			'ancestors' => $ancestors,
			'descendants' => $descendants,
			'formModel' => $formModel,
		));
	}
	
	/**
	 * Removes the child from the item with the given name.
	 * @param string $itemName name of the item.
	 * @param string $childName name of the child.
	 */
	public function actionRemoveChild($itemName, $childName)
	{
		/* @var $am CAuthManager|AuthBehavior */
		$am = Yii::app()->getAuthManager();

		if ($am->hasItemChild($itemName, $childName))
		{
			$am->removeItemChild($itemName, $childName);
			if ($am instanceof CPhpAuthManager)
				$am->save();
		}

		$this->redirect(array('updateRole', 'name' => $itemName));
	}
	
	public function actionCreateRole()
	{
		$this->layout = 'admin';
		
		$model = new AuthItemForm('create');
		
		if (isset($_POST['AuthItemForm']))
		{
			$model->attributes = $_POST['AuthItemForm'];
			if ($model->validate())
			{	
				$auth=Yii::app()->authManager;
				$role=$auth->createRole($model->name, $model->description);

				$this->redirect(array('roles'));
			}
		}
		
		$this->render('roles/create', array(
			'model'=>$model,
		));
	}
	
	public function actionDeleteRole($name)
	{
		/* @var $am CAuthManager|AuthBehavior */
		$am = Yii::app()->getAuthManager();

		$item = $am->getAuthItem($name);
		if ($item instanceof CAuthItem)
		{
			$am->removeAuthItem($name);
			if ($am instanceof CPhpAuthManager)
				$am->save();

			if (!isset($_POST['ajax']))
				$this->redirect(array('roles'));
		}
		else
			throw new CHttpException(404, Yii::t('AuthModule.main', 'Item does not exist.'));
	}
	
	public function actionOperations()
	{
		$this->layout = 'admin';
		
		$roles = CmsUser::getOperationsAsListData();

		$this->render('operations/admin', array(
			'roles'=>$roles,
		));
	}
	
	public function actionUpdateOperation($name)
	{
		$this->layout = 'admin';
		
		/* @var $am CAuthManager|AuthBehavior */
		$am = Yii::app()->getAuthManager();

		$item = $am->getAuthItem($name);

		if ($item === null)
			throw new CHttpException(404, Yii::t('AuthModule.main', 'Page not found.'));

		$model = new AuthItemForm('update');

		if (isset($_POST['AuthItemForm']))
		{
			$model->attributes = $_POST['AuthItemForm'];
			if ($model->validate())
			{
				$item->description = $model->description;

				$am->saveAuthItem($item);
				if ($am instanceof CPhpAuthManager)
					$am->save();

				$this->redirect(array('operations'));
			}
		}

		$model->name = $name;
		$model->description = $item->description;
		$model->type = $item->type;

		$this->render('operations/update', array(
			//'item' => $item,
			'model' => $model,
		));
	}

	public function actionCreateOperation()
	{
		$this->layout = 'admin';
		
		$model = new AuthItemForm('create');

		if (isset($_POST['AuthItemForm']))
		{
			$model->attributes = $_POST['AuthItemForm'];
			if ($model->validate())
			{
				$auth=Yii::app()->authManager;
				$auth->createOperation($model->name, $model->description);

				$this->redirect(array('operations'));
			}
		}

		$this->render('operations/create', array(
			'model' => $model,
		));
	}
	
	/**
	 * Deletes the item with the given name.
	 * @throws CHttpException if the item does not exist or if the request is invalid.
	 */
	public function actionDeleteOperation($name)
	{
		/* @var $am CAuthManager|AuthBehavior */
		$am = Yii::app()->getAuthManager();

		$item = $am->getAuthItem($name);
		if ($item instanceof CAuthItem)
		{
			$am->removeAuthItem($name);
			if ($am instanceof CPhpAuthManager)
				$am->save();

			if (!isset($_POST['ajax']))
				$this->redirect(array('operations'));
		}
		else
			throw new CHttpException(404, Yii::t('AuthModule.main', 'Item does not exist.'));
	}
}