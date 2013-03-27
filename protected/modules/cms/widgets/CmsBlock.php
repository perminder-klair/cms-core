<?php

/**
 * Widget that renders the node with the given name.
 */
class CmsBlock extends CWidget
{
        /**
         * @property string the content name.
         */
        public $name;
        public $blockParent;

        /**
         * Runs the widget.
         */
        public function run()
        {
                $app = Yii::app();
                $model = $app->cms->loadBlock($this->name, $this->blockParent);

                //if not found
		        /*if ($model === null)
		        {
		            $cms = Yii::app()->cms;
		            $cms->createNode($this->name);
		            $model = $cms->loadNode($this->name);
		        }*/

                // Ensure that we only render block-level nodes.
                if ($model->published /*&& $model->level === CmsNode::LEVEL_BLOCK*/) { 
                        /*if ($model->content !== null && !empty($model->content->css))
                                $app->clientScript->registerCss($model->name.'#'.$this->getId(), $model->content->css);*/

                        $this->render('block', array(
                                'model'=>$model,
                                'content'=>$model->renderWidget(),
                        ));
                }
        }
}