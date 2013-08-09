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

        // Ensure that we only render block-level nodes.
        if ($model->published) {

            $this->render('block', array(
                'model'=>$model,
                'content'=>$model->renderWidget(),
            ));

        }
    }
}