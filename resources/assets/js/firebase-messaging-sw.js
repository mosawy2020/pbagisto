importScripts("https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js");
importScripts("https://www.gstatic.com/firebasejs/8.3.2/firebase-messaging.js");

try {
    firebase.initializeApp({
        apiKey: process.env.MIX_FIREBASE_API_KEY,
        authDomain: process.env.MIX_FIREBASE_AUTH_DOMAIN,
        projectId: process.env.MIX_FIREBASE_PROJECT_ID,
        storageBucket: process.env.MIX_FIREBASE_STRORAGE_BUCKET,
        messagingSenderId: process.env.MIX_FIREBASE_MESSAGING_SENDER_ID,
        appId: process.env.MIX_FIREBASE_APP_ID
    });
    var messaging = firebase.messaging();
    self.addEventListener("notificationclick", function (event) {
    const target = event.notification.data.click_action || "/";
    event.notification.close();
    // This looks to see if the current is already open and focuses if it is event.waitUntil(
    clients
        .matchAll({
            type: "window",
            includeUncontrolled: true,
        })
        .then(function (clientList) {
            // clientList always is empty?!
            for (var i = 0; i < clientList.length; i++) {
                var client = clientList[i];
                if (client.url === target && "focus" in client) {
                    return client.focus();
                }
            }
            return clients.openWindow(target);
        });
    });
    messaging.onBackgroundMessage((payload) => {
        console.log(
            "[firebase-messaging-sw.js] Received background message ",
            payload);
        // Customize notification here
        const notificationTitle = payload.notification.title;
        const notificationOptions = {
            body: payload.notification.body,
            icon: payload.notification.icon ? payload.notification.icon : null
        };
        self.registration.showNotification(
            notificationTitle,
            notificationOptions
        );
    });

}catch(e){
    console.log(e);
}