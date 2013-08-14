<?php

/**
 * Widget that renders the node with the given name.
 */
class OoCharts extends CWidget
{
    public $apiKey=null;
    public $appId=null;

    /**
     * Runs the widget.
     */
    public function run()
    {
        if(isset($this->apiKey) && isset($this->appId))
            $this->render('ooCharts', array(
                'apiKey'=>$this->apiKey,
                'appId'=>$this->appId,
            ));
    }
}