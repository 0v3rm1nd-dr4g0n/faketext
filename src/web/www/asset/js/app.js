/**
 * @author Nguyen Huu Phuoc <huuphuoc.me>
 * @copyright (c) 2013 Nguyen Huu Phuoc
 */

angular
    .module('FakeText', [])
    .controller('IndexController', function($rootScope, $scope, $http) {
        $scope.data = {
            operator: 'Operator',
            hour: 0,
            minute: 0,
            batteryPercent: '100%',
            receiver: '',
            connection: 'none'
        };

        $scope.DAY_HOURS   = [];
        $scope.DAY_MINUTES = [];
        $scope.time        = '00:00 AM';

        // Connection type
        $scope.CONNECTION_TYPES = ['3G', 'Edge', 'Wifi', 'None'];

        // New message model
        $scope.content = '';
        $scope.from    = 'sender';

        // Array of messages
        $scope.messages = [];

        /**
         * Init the controller
         */
        $scope.init = function() {
            $scope.DAY_HOURS   = $scope.createRange(0, 23);
            $scope.DAY_MINUTES = $scope.createRange(0, 59);
        };

        // --- Public methods ---

        /**
         * Set the connection type
         * @param connection
         */
        $scope.setConnectionType = function(connection) {
            $scope.data.connection = connection.toLowerCase();
        };

        /**
         * Add new message to conversation
         */
        $scope.addMessage = function() {
            if ('' == $scope.content) {
                return;
            }
            $scope.messages.push({
                content: $scope.content,
                from: $scope.from
            });
            $scope.content = '';
            $scope.from    = ('sender' == $scope.from) ? 'receiver' : 'sender';
        };

        /**
         * Remove message from the conversation
         * @param index The index of message
         */
        $scope.removeMessage = function(index) {
            $scope.messages.splice(index, 1);
        };

        /**
         * Download image
         */
        $scope.download = function(evt) {
            if ($scope.messages.length == 0) {
                evt.preventDefault();
                return false;
            }

            // Submit form
            var form = evt.target.form;
            // Set the value for hidden fields manually
            // Cannot use ng-model
            form.connection.value = $scope.data.connection;
            form.messages.value   = JSON.stringify($scope.messages);
            form.submit();
        };

        // --- Private methods ---

        /**
         * Create an array consists of number in given range
         * @param start
         * @param end
         * @returns {Array}
         */
        $scope.createRange = function(start, end) {
            var array = [];
            for (var i = start; i <= end; i++) {
                array.push(i);
            }
            return array;
        };
    });