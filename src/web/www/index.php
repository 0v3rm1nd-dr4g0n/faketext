<!doctype html>
<html ng-app="FakeText">
<head>
    <meta charset="UTF-8">
    <title>Fake iPhone messages</title>
    <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap-responsive.min.css"/>
    <link rel="stylesheet" href="asset/css/style.css"/>
    <!--[if lt IE 9]>
    <script src="vendor/jquery/jquery-1.10.1.min.js"></script>
    <![endif]-->
    <!--[if gte IE 9]><!-->
    <script src="vendor/jquery/jquery-2.0.2.min.js"></script>
    <!--<![endif]-->
    <script type="text/javascript" src="vendor/angular/angular.1.0.7.min.js"></script>
    <!--[if lt IE 9]>
    <script src="vendor/html5shiv/html5shiv.min.js"></script>
    <![endif]-->
    <script type="text/javascript" src="asset/js/app.js"></script>
</head>
<body>
    <div id="wrap">
        <!-- content: -->
        <div class="container" id="main" ng-controller="IndexController" ng-init="init()">
            <div class="page-header">
                <h1>Fake iPhone messages</h1>

                <div class="ft-share">
                    <!-- AddThis Button BEGIN -->
                    <div class="addthis_toolbox addthis_default_style">
                        <a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
                        <a class="addthis_button_tweet"></a>
                        <a class="addthis_button_google_plusone" g:plusone:size="medium"></a>
                        <a class="addthis_button_pinterest_pinit"></a>
                    </div>
                    <!-- AddThis Button END -->
                </div>
            </div>

            <div class="row-fluid">
                <!-- config: -->
                <div class="span6">
                    <form action="download.php" method="POST">
                    <fieldset>
                        <legend>Settings</legend>

                        <div class="row-fluid">
                            <div class="span6">
                                <label>Operator</label>
                                <input type="text" placeholder="AT&T, Vinaphone, etc." ng-model="data.operator" name="operator">
                            </div>
                            <div class="span6">
                                <label>Connection</label>
                                <div class="btn-group">
                                    <a class="btn" ng-repeat="i in CONNECTION_TYPES" ng-click="setConnectionType(i)" ng-class="{ 'btn-success active': data.connection.toUpperCase() == i.toUpperCase() }">{{ i }}</a>
                                </div>
                                <input type="hidden" name="connection" ng-model="connection"/>
                            </div>
                        </div>

                        <div class="row-fluid">
                            <div class="span6">
                                <label>Receiver Name</label>
                                <input type="text" placeholder="Receiver" ng-model="data.receiver" name="receiver">
                            </div>
                            <div class="span6">
                                <label>Time</label>
                                <div>
                                    <select ng-model="data.hour" class="input-small" name="hour">
                                        <option value="0">Hour</option>
                                        <option ng-repeat="i in DAY_HOURS" value="{{ i }}">{{ i }}</option>
                                    </select>
                                    <select ng-model="data.minute" class="input-small" name="minute">
                                        <option value="0">Minute</option>
                                        <option ng-repeat="i in DAY_MINUTES" value="{{ i }}">{{ i }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </fieldset>

                    <fieldset>
                        <legend>Messages</legend>

                        <div class="ft-input-message">
                            <div class="row-fluid form-inline">
                                <textarea class="input-xlarge" ng-model="content"></textarea>
                                <select class="input-small" ng-model="from">
                                    <option value="sender">Sender</option>
                                    <option value="receiver">Receiver</option>
                                </select>
                                <a class="btn btn-success" ng-click="addMessage()">Add</a>
                            </div>

                            <ul class="form-inline">
                                <li ng-repeat="m in messages">
                                    <textarea class="input-xlarge" ng-model="m.content"></textarea>
                                    <select class="input-small" ng-model="m.from">
                                        <option value="sender">Sender</option>
                                        <option value="receiver">Receiver</option>
                                    </select>
                                    <span class="btn-group">
                                        <a class="btn" ng-click="removeMessage($index)"><i class="icon-remove"></i></a>
                                        <a class="btn" ng-click="moveUpMessage($index)" ng-class="{ 'disabled': $index == 0 }"><i class="icon-arrow-up"></i></a>
                                        <a class="btn" ng-click="moveDownMessage($index)" ng-class="{ 'disabled': $index == messages.length - 1 }"><i class="icon-arrow-down"></i></a>
                                    </span>
                                </li>
                            </ul>
                        </div>
                    </fieldset>

                    <div class="text-center" style="margin-top: 20px;">
                        <button class="btn btn-primary btn-large" type="button" ng-click="download($event)"><i class="icon-download-alt icon-white"></i> Download Image</button>
                    </div>

                        <input type="hidden" name="messages" ng-model="data.messages"/>
                    </form>
                </div>
                <!-- :config -->

                <!-- preview: -->
                <div class="span6">
                    <div class="ft-preview">
                        <!-- preview/top: -->
                        <div class="row-fluid ft-preview-top">
                            <div class="ft-operator">
                                <img src="asset/img/iphone-top-signal.jpg" width="39" height="30" alt=""/>
                                <span>{{ data.operator }} </span>
                                <img ng-src="asset/img/iphone-connection-{{ data.connection }}.jpg" width="26" height="30" alt=""/>
                            </div>
                            <div class="ft-battery">
                                <span>{{ data.batteryPercent }}%</span>
                                <img src="asset/img/iphone-battery.jpg" width="41" height="30" alt=""/>
                            </div>
                            <div class="ft-time">
                                {{ formatTime() }}
                            </div>
                        </div>
                        <!-- :preview/top -->

                        <!-- preview/header: -->
                        <div class="row-fluid ft-preview-header">
                            <div class="ft-btn-message">Messages</div>
                            <div class="ft-btn-edit">Edit</div>
                            <h2>{{ formatReceiver() }}</h2>
                        </div>
                        <!-- :preview/header -->

                        <!-- preview/messages: -->
                        <div class="row-fluid ft-preview-message">
                            <ul>
                                <li ng-repeat="m in messages" ng-class="{ 'ft-message-blue': 'sender' == m.from, 'ft-message-grey': 'receiver' == m.from }">
                                    <p>{{ m.content }}</p>
                                    <div></div>
                                </li>
                            </ul>
                        </div>
                        <!-- :preview/messages -->

                        <!-- preview/footer: -->
                        <div class="ft-preview-footer">

                        </div>
                        <!-- :preview/footer -->
                    </div>
                </div>
                <!-- :preview -->
            </div>
        </div>
        <!-- :content -->

        <div id="push"></div>
    </div>

    <!-- footer: -->
    <footer>
        <div class="container">
            <div class="row-fluid">
                &copy; <?= date('Y'); ?> Nguyen Huu Phuoc (<a href="http://twitter.com/nghuuphuoc">@nghuuphuoc</a>)<br>
                Just another weekend project from APL Solutions.
            </div>
        </div>
    </footer>
    <!-- :footer -->

    <script type="text/javascript" src="http://s7.addthis.com/js/300/addthis_widget.js#pubid=undefined"></script>
</body>
</html>