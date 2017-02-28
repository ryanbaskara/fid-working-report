package com.fujitsu.fidworkingreport;

import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.widget.TextView;

public class Notification extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_notification);
        TextView title_view, content_view, date_view;

        SharedPreferences sharedPreferences;
        sharedPreferences = getSharedPreferences("Notification", Context.MODE_PRIVATE);
        String title = sharedPreferences.getString(Config.TAG_TITLE,"");
        String content = sharedPreferences.getString(Config.TAG_CONTENT,"");
        String date = sharedPreferences.getString(Config.TAG_DATE,"");


        title_view = (TextView)findViewById(R.id.title);
        assert title_view != null;
        title_view.setText(title);
        content_view = (TextView)findViewById(R.id.content);
        assert content_view != null;
        content_view.setText(content);
        date_view = (TextView)findViewById(R.id.time);
        assert date_view != null;
        date_view.setText(date);
        getSupportActionBar().setTitle("Notification");
    }
}
