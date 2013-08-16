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
        if (isset($this->blockParent) && isset($this->name)) {
            $model = CmsBlocks::model()->published()->findByAttributes(array('name'=>$this->name,'parentId'=>$this->blockParent));

            // Ensure that we only render block-level nodes.
            if ($model->published) {

                $this->render('block', array(
                    'model'=>$model,
                    'content'=>$model->renderWidget(),
                ));

            }
        }
    }
}