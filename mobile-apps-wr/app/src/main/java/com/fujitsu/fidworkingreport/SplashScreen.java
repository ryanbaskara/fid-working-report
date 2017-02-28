package com.fujitsu.fidworkingreport;

import android.app.Activity;
import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;

public class SplashScreen extends Activity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.splash_screen);
        Thread timerThread = new Thread(){
            public void run(){
                try{
                    sleep(2000);
                }catch(InterruptedException e){
                    e.printStackTrace();
                }finally{
                    SharedPreferences sharedPreferences;
                    sharedPreferences = getSharedPreferences("Login", Context.MODE_PRIVATE);
                    String token = sharedPreferences.getString(Config.TAG_TOKEN,"");
                    if (token.isEmpty()) {
                        startActivity(new Intent(SplashScreen.this, LoginActivity.class));
                    }else {
                        Intent intent = new Intent(SplashScreen.this,MainActivity.class);
                        startActivity(intent);
                    }
                }
            }
        };
        timerThread.start();
    }
    @Override
    protected void onPause() {
        super.onPause();
        finish();
    }
}
