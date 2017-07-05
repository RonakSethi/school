var agent = require('./apnagent_header');

exports.sendNotification = function (iosToken, message, payloadValue, notTypeValue, badgeCount) {
    var badge = 1;

    if (typeof badgeCount != 'undefined' && badgeCount != '') {
        console.log(badgeCount);
        badge = badgeCount;
    }
    agent.createMessage()
            .device(iosToken)
            .alert(message)
            .set('notInfo', payloadValue)
            .set('notType', notTypeValue)
            .badge(badge)
            .sound('default')
            .send();
    console.log(iosToken);
    console.log(message);
    console.log("Push send");
}
