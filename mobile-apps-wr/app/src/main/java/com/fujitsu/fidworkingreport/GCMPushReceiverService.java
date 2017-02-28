package com.fujitsu.fidworkingreport;
import android.app.NotificationManager;
import android.app.PendingIntent;
import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.media.RingtoneManager;
import android.net.Uri;
import android.os.Bundle;
import android.support.v4.app.NotificationCompat;
import android.util.Log;
import android.widget.Toast;

import com.google.android.gms.gcm.GcmListenerService;

import org.json.JSONException;
import org.json.JSONObject;


//Class is extending GcmListenerService
public class GCMPushReceiverService extends GcmListenerService {

    //This method will be called on every new message received
    @Override
    public void onMessageReceived(String from, Bundle data) {
        SharedPreferences sharedPreferences;
        sharedPreferences = getSharedPreferences("Login", Context.MODE_PRIVATE);
        String token = sharedPreferences.getString(Config.TAG_TOKEN,"");
        //Getting the message from the bundle
        String message = data.getString("message");
        //Displaying a notiffication with the message
        if (!token.isEmpty()) {
            sendNotification(message);
        }
    }

    //This method is generating a notification and displaying the notification
    private void sendNotification(String message) {
        String title=null,content=null,timestamp=null,date=null;
        JSONObject jsonObject = null;
        try {
            jsonObject = new JSONObject(message);
            title = jsonObject.getString(Config.TAG_TITLE);
            content = jsonObject.getString(Config.TAG_CONTENT);
            date = jsonObject.getString(Config.TAG_DATE);

        } catch (JSONException e) {
            e.printStackTrace();
        }
        SharedPreferences sharedPreferences;
        sharedPreferences = getSharedPreferences("Notification", Context.MODE_PRIVATE);
        SharedPreferences.Editor editor = sharedPreferences.edit();
        editor.putString(Config.TAG_TITLE,title);
        editor.putString(Config.TAG_CONTENT,content);
        editor.putString(Config.TAG_DATE,date);
        editor.apply();

        Intent intent = new Intent(this, Notification.class);
        intent.addFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);

        int requestCode = 0;
        PendingIntent pendingIntent = PendingIntent.getActivity(this, requestCode, intent, PendingIntent.FLAG_ONE_SHOT);
        Uri sound = RingtoneManager.getDefaultUri(RingtoneManager.TYPE_NOTIFICATION);

        Bitmap bitmap = BitmapFactory.decodeResource(getResources(),R.drawable.notification_logo);

        NotificationCompat.Builder noBuilder = new NotificationCompat.Builder(this)
                .setSmallIcon(R.drawable.just_logo_red)
                .setLargeIcon(bitmap)
                .setContentTitle(title)
                .setContentText(content)
                .setStyle(new NotificationCompat.BigTextStyle().bigText(content))
                .setSound(sound)
                .setAutoCancel(true)
                .setContentIntent(pendingIntent);

        NotificationManager notificationManager = (NotificationManager)getSystemService(Context.NOTIFICATION_SERVICE);
        notificationManager.notify(0, noBuilder.build()); //0 = ID of notification
    }
}