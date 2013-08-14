<!-- CHARTS  -->
<div class="row-fluid">
    <div class="widget span3">
        <div class="widget-header">
            <i class="icon-bar-chart"></i>
            <h5>Monthly Statistics</h5>
            <div class="widget-buttons">
                <a href="javascript:void(0)" class="collapse" data-collapsed="false"><i data-title="Collapse" class="icon-chevron-up"></i></a>
            </div>
        </div>
        <div class="widget-body clearfix">
            <div class="widget-analytics-small" style="height:289px;">
                <ul>
                    <li>
                        <h5>Visits:</h5>
                        <h4><span id='visits'></span></h4>
                    </li>
                    <li>
                        <h5>Pageviews:</h5>
                        <h4><span id="pageviews"></span></h4>
                    </li>
                    <li>
                        <h5>Bounces:</h5>
                        <h4><span id='bounce'></span></h4>
                    </li>
                    <li>
                        <h5>New Visitors:</h5>
                        <h4><span id="newVisits"></span></h4>
                    </li>
                </ul>
            </div>
        </div> <!-- /widget body -->
    </div> <!-- /widget span12 -->
    <div class="widget span9">
        <div class="widget-header">
            <i class="icon-credit-card"></i>
            <h5>Audience Overview</h5>
            <div class="widget-buttons">
                <a href="javascript:void(0)" class="collapse" data-collapsed="false"><i data-title="Collapse" class="icon-chevron-up"></i></a>
            </div>
        </div>
        <div class="widget-body clearfix">
            <div id='timeline' style="height:274px;" class="widget-analytics-large"></div>
        </div>
    </div>
</div> <!-- /row-fluid -->

<script src='<?php echo Yii::app()->cms->assetsUrl; ?>/js/oocharts.js'></script>
<script type="text/javascript">

    var apiKey = "<?php echo $apiKey; ?>";
    var appId = "<?php echo $appId; ?>";

    window.onload = function(){

        oo.setAPIKey(apiKey);

        oo.load(function(){

            //Timeline
            var timeline = new oo.Timeline(appId, "30d");
            timeline.addMetric("ga:visits", "Visits");
            timeline.addMetric("ga:newVisits", "New Visits");
            timeline.draw('timeline');

            //visits
            var metric = new oo.Metric(appId, "30d");
            metric.setMetric("ga:visits");
            metric.draw('visits');

            //bounce
            var metric = new oo.Metric(appId, "30d");
            metric.setMetric("ga:bounces");
            metric.draw('bounce');

            //new visitors
            var metric = new oo.Metric(appId, "30d");
            metric.setMetric("ga:newVisits");
            metric.draw('newVisits');

            //page views
            var metric = new oo.Metric(appId, "30d");
            metric.setMetric("ga:pageviews");
            metric.draw('pageviews');

        });
    };

</script>