<?php

/**
 * 
 */
class TestIntentConfiguration
{
    public $requestString = <<< EOM
{
  "session": {
    "sessionId": "SessionId.ce70f981-5b47-47f7-833e-2a9f893e4310",
    "application": {
      "applicationId": "amzn1.ask.skill.87abceb2-5070-4651-9379-db5e7ca5306f"
    },
    "attributes": {},
    "user": {
      "userId": "amzn1.ask.account.AHKTH3ERBVTFPZAI7J4PKEG2L2GTROYNSBBUIVSXLJO5ENDUUC3UNEOI63BQNGBVX44V6EJ2YZPDHQM23J4YAQFXJUWON3SFTANGYCBXVHZZTWV2XBOUPKLUGH6PCLYNTBRQMT7OE2AXUQ7U7SSHXM2HGS7ELELUYHO7AE7SZ3YXWH4SFWCRJA5ULNHPUDC7PYWWXFUU7VI6KPQ"
    },
    "new": true
  },
  "request": {
    "type": "IntentRequest",
    "requestId": "EdwRequestId.a266cb4f-cf6d-4d27-b659-656346ce80c4",
    "locale": "de-DE",
    "timestamp": "2017-07-14T13:05:33Z",
    "intent": {
      "name": "ConfigureHaltestelleIntent",
      "slots": {
        "Haltestelle": {
          "name": "Haltestelle",
          "value": "aachener gürtel"
        }
      }
    }
  },
  "version": "1.0"
}
EOM;

}