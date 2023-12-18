## Why flutter and compare


| Time | Name              | Core                               | Native support | Dynamic support | Performance | Experience |
|------|-------------------|------------------------------------|----------------|-----------------|-------------|------------|
| 2012 | Ionic/Cordova     | JSBridge to Web usage(webview)     | 90%            | Mid             | Bad         | Bad        |
| 2015 | React Native/Weex | JIT communicate with native render | 20%            | Good            | Mid         | Mid        |
| 2018 | Flutter           | Self render                        | 5%             | Great           | Good        | Great      |

### Ionic / Cordova

Core concept: JSBridge to package features for web to use, extend webview.

Cons:
* Depend on webview, so performance is bad, also experience is unknown.

### React Native / Weex

Javascript communicate with native render.

Pros:
* Experience is highly same as native.

Cons:
* JIT need frequent communication with native render, this will influence performance.

### Flutter

Pros:
Self render, so better performance.

> Choose flutter is not to replace Android/iOS but complementary, use Flutter to implement Business Logic, Android/iOS to implement native features.  



