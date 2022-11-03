<template>
  <div>
    <Transition name="slide-fade">
      <div class="request-permission-wrapper" v-if="showGrantPermission">
        <div class="container">
          <div class="request-permission">
            <p>{{ notificationRequestTitle }}</p>
            <div>
              <button
                class="button btn btn-primary"
                @click="requestPermission()"
              >
                {{ notifictionAccept }}
              </button>
              <button
                class="button btn btn-grey"
                @click="cancelPermission()"
              >
                {{ notifictionCancel }}
              </button>
            </div>
          </div>
        </div>
      </div>
    </Transition>
  </div>
</template>

<script>
// import { initializeApp } from "firebase/app";
// import {  getToken } from "firebase/messaging";
// import { getMessaging } from "firebase/messaging/sw";
import firebase from "firebase/app";
import "firebase/analytics";
import "firebase/messaging";
import Cookies from "js-cookie";

export default {
  props: [
    "notifTitle",
    "viewAll",
    "title",
    "viewAllTitle",
    "readAllTitle",
    "localeCode",
    "apiKey",
    "authDomain",
    "projectId",
    "storageBucket",
    "messagingSenderId",
    "appId",
    "vapidKey",
    "tokenUrl",
    "notificationRequestTitle",
    "notifictionAccept",
    "notifictionCancel"
  ],

  data() {
    return {
      notifications: [],

      totalUnRead: 0,
      showGrantPermission: false,

      firebaseData: {
        token: null,
        device: null,
      },
    };
  },

  mounted() {
    console.log(process.env.MIX_FIREBASE_API_KEY);
    // this.initiateFirebaseFunc()
console.log(Notification.permission)
    if (Notification.permission === "granted") {
      this.showGrantPermission = false;
      this.requestPermission();
    }else{
        this.showGrantPermission = true;
    }


  },

  methods: {
    requestPermission() {
      let permission = Notification.permission;
      let da = this;
      if (permission === "granted") {
        this.initiateFirebaseWithScript();
        this.showGrantPermission = false;
      } else if (permission === "default") {
        Notification.requestPermission(function (permission) {
          if (permission === "granted") {
            da.showGrantPermission = false;
            location.reload();
            // da.initiateFirebaseWithScript();
          }
        });
      } else {
      }
    },
    // initiateFirebaseFunc(){
    //     const firebaseConfig = {
    //         apiKey: "AIzaSyAbVHtVGVIEbCmIqNUkKe3fzQSqrRrnARw",
    //         authDomain: "pura-413af.firebaseapp.com",
    //         projectId: "pura-413af",
    //         storageBucket: "pura-413af.appspot.com",
    //         messagingSenderId: "422593871175",
    //         appId: "1:422593871175:web:e5804078c8c732352ea062"
    //     };
    //     initializeApp(firebaseConfig);
    //     const messaging = getMessaging();
    //     console.log(messaging);
    //     getToken(messaging, { vapidKey: this.vapidKey  }).then((currentToken) => {
    //         if (currentToken) {
    //             // Send the token to your server and update the UI if necessary
    //             console.log("UserToken",currentToken);
    //             this.firebaseData.token = currentToken
    //             this.fnBrowserDetect()
    //             this.getNotifications()
    //             // ...
    //         } else {
    //             // Show permission request UI
    //             console.log('No registration token available. Request permission to generate one.');
    //             // ...
    //         }
    //         }).catch((err) => {
    //         console.log('An error occurred while retrieving token. ', err);
    //         // ...
    //     });
    // },
    initiateFirebaseWithScript() {
      const firebaseConfig = {
        apiKey: this.apiKey,
        authDomain: this.authDomain,
        projectId: this.projectId,
        storageBucket: this.storageBucket,
        messagingSenderId: this.messagingSenderId,
        appId: this.appId,
      };

      firebase.initializeApp(firebaseConfig);
      const messaging = firebase.messaging();
      // console.log(messaging);
      messaging
        .getToken(messaging, { vapidKey: this.vapidKey })
        .then((currentToken) => {
          if (currentToken) {
            // Send the token to your server and update the UI if necessary
            // console.log("UserToken",currentToken);
            this.firebaseData.token = currentToken;
            this.fnBrowserDetect();
            if (!this.isTokenSetToCookies(currentToken)) {
              this.saveToken();
            }

            // ...
          } else {
            // Show permission request UI
            console.log(
              "No registration token available. Request permission to generate one."
            );
            // ...
          }
        })
        .catch((err) => {
          console.log("An error occurred while retrieving token. ", err);
          // ...
        });
      messaging.onMessage(function (payload) {
        const noteTitle = payload.notification.title;
        const noteOptions = {
          body: payload.notification.body,
          icon: payload.notification.icon,
        };
        new Notification(noteTitle, noteOptions);
      });
    },
    saveToken() {
      axios
        .post(this.tokenUrl, this.firebaseData)
        .then((response) => {
          // console.log(response)
        })
        .catch((error) => {});
    },
    fnBrowserDetect() {
      let userAgent = navigator.userAgent;

      if (userAgent.match(/chrome|chromium|crios/i)) {
        this.firebaseData.device = "chrome";
      } else if (userAgent.match(/firefox|fxios/i)) {
        this.firebaseData.device = "firefox";
      } else if (userAgent.match(/safari/i)) {
        this.firebaseData.device = "safari";
      } else if (userAgent.match(/opr\//i)) {
        this.firebaseData.device = "opera";
      } else if (userAgent.match(/edg/i)) {
        this.firebaseData.device = "edge";
      } else {
        browserName = "No browser detection";
      }
    },
    isTokenSetToCookies(currentToken) {
      let cookieIsSet = false;
      if (Cookies.get("notification_firebase") == currentToken) {
        cookieIsSet = true;
      } else {
        Cookies.set("notification_firebase", currentToken);
        cookieIsSet = false;
      }
      return cookieIsSet;
    },
    cancelPermission() {
      this.showGrantPermission = false;
    },
  },
};
</script>

<style scoped lang="scss">
.slide-fade-enter-active {
  transition: all 0.3s ease-out;
}

.slide-fade-leave-active {
  transition: all 0.8s cubic-bezier(1, 0.5, 0.8, 1);
}

.slide-fade-enter-from,
.slide-fade-leave-to {
  transform: translateX(20px);
  opacity: 0;
}
.request-permission-wrapper {
  position: fixed;
  bottom: 0;
  left: 0;
  right: 0;
  z-index: 2;
  background: #fff;
  min-height: 3rem;
  padding: 0.5rem 0;
  .request-permission {
    display: flex;
    justify-content: space-between;
    align-items: center;
  }
  p {
    padding: 1rem;
    font-size: 1rem;
    margin-bottom: 0;
  }
  .btn-grey{
    background: #aca9a9!important;
    border-color: #aca9a9!important;
    color:#fff
  }
}
</style>