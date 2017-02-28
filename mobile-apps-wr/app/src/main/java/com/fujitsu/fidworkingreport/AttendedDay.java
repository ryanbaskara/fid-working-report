package com.fujitsu.fidworkingreport;


import android.app.ProgressDialog;
import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.os.AsyncTask;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.app.TimePickerDialog;
import android.support.v7.widget.Toolbar;
import android.text.TextUtils;
import android.util.Log;
import android.view.KeyEvent;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.view.inputmethod.EditorInfo;
import android.widget.AutoCompleteTextView;
import android.widget.Button;
import android.widget.TextView;
import android.widget.TimePicker;
import android.widget.Toast;

import org.json.JSONException;
import org.json.JSONObject;

import java.util.Calendar;
import java.util.HashMap;

public class AttendedDay extends AppCompatActivity {
    private int mYear, mMonth, mDay, mHour, mMinute, temp_time_in = 800, temp_time_out = 1700, temp_time_break = 100, temp_overtime = 0, temp_totaltime = 800;
    AutoCompleteTextView place, activity ;
    TextView time_in, time_out, time_break, overtime, totaltime,d_place,d_activity;
    //Toolbar toolbarDate;
    String JSON_STRING, temp_place, temp_activity;
    Button submit;
    AttendedDayTask mAttendedDayTask;
    DeleteAttendedDay deleteAttendedDay;
    private String timed_in, timed_out, timed_break, i_place, i_activity,status,i_date, i_date2, i_totaltime, i_overtime, edit,month,year;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        getDataIntent();
        super.onCreate(savedInstanceState);

        if (edit.equals("1")){
            setContentView(R.layout.activity_attended_day);
            initialization();
            activity = (AutoCompleteTextView) findViewById(R.id.activity);
            place = (AutoCompleteTextView) findViewById(R.id.place);
            if (status.equals("1")){
                activity.setText(i_activity);
                place.setText(i_place);
                setValue();
            }else{
                timed_in="08:00";
                timed_out="17:00";
                timed_break="01:00";
            }
            place.setOnEditorActionListener(new TextView.OnEditorActionListener() {
                @Override
                public boolean onEditorAction(TextView textView, int id, KeyEvent keyEvent) {
                    if (id == R.id.ime_place ) {
                        View focusView = activity;
                        focusView.requestFocus();
                        return true;
                    }
                    return false;
                }
            });
            activity.setOnEditorActionListener(new TextView.OnEditorActionListener() {
                @Override
                public boolean onEditorAction(TextView textView, int id, KeyEvent keyEvent) {
                    if (id == R.id.ime_activity || id == EditorInfo.IME_NULL) {
                        attendedDaySubmit();
                        return true;
                    }
                    return false;
                }
            });
        }
        if (edit.equals("0")){
            if (status.equals("1")){
                setContentView(R.layout.activity_attended_day_disabled);
                initialization();
                d_place = (TextView)findViewById(R.id.place);
                d_activity = (TextView)findViewById(R.id.activity);
                d_place.setText(i_place);
                d_activity.setText(i_activity);
                setValue();
            }else{
                setContentView(R.layout.activity_attended_day_disabled_no_record);
            }
        }
        SharedPreferences sharedPreferences;
        sharedPreferences = getSharedPreferences("Login", Context.MODE_PRIVATE);
        String id_user = sharedPreferences.getString(Config.TAG_ID,"");
        String name = sharedPreferences.getString(Config.TAG_NAME,"");
        String position = sharedPreferences.getString(Config.TAG_POSITION,"");
        TextView viewName = (TextView)findViewById(R.id.viewName);
        TextView viewPosition = (TextView)findViewById(R.id.viewPosition);
        viewName.setText(name+" ("+id_user+")");
        viewPosition.setText(position);

        //setSupportActionBar(toolbar);
        getSupportActionBar().setTitle(i_date);

    }

    private void initialization(){
        time_in=(TextView)findViewById(R.id.time_in_text);
        time_out=(TextView)findViewById(R.id.time_out_text);
        time_break=(TextView)findViewById(R.id.time_break_text);
        overtime=(TextView)findViewById(R.id.overtime_text);
        totaltime=(TextView)findViewById(R.id.totaltime_text);
    }
    private int setHour(String time){
        String tmp_hour = time.substring(0,2);
        int hour = Integer.parseInt(tmp_hour);
        return hour;
    }
    private int setMinutes(String time){
        String tmp_minutes = time.substring(3);
        int minutes = Integer.parseInt(tmp_minutes);
        return minutes;
    }
    private void setValue(){
        time_in.setText(timed_in);
        time_out.setText(timed_out);
        time_break.setText(timed_break);
        totaltime.setText(i_totaltime);
        overtime.setText(i_overtime);
    }

    private void getDataIntent(){
        Intent intent = getIntent();
        i_date2 = intent.getStringExtra(Config.TAG_DATE2);
        i_date = intent.getStringExtra(Config.TAG_DATE);
        timed_in = intent.getStringExtra(Config.TAG_TIME_IN);
        timed_out = intent.getStringExtra(Config.TAG_TIME_OUT);
        timed_break = intent.getStringExtra(Config.TAG_TIME_BREAK);
        i_activity = intent.getStringExtra(Config.TAG_ACTIVITY);
        i_place = intent.getStringExtra(Config.TAG_PLACE);
        i_overtime = intent.getStringExtra(Config.TAG_OVERTIME);
        i_totaltime = intent.getStringExtra(Config.TAG_TOTALTIME);
        status = intent.getStringExtra(Config.TAG_STATUS);
        edit = intent.getStringExtra(Config.TAG_EDIT);
        month = intent.getStringExtra(Config.TAG_MONTH2);
        year = intent.getStringExtra(Config.TAG_YEAR);
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu){
        if (edit.equals("1")) {
            getMenuInflater().inflate(R.menu.attended_day, menu);
        }
        return super.onCreateOptionsMenu(menu);
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item){

        switch(item.getItemId()){
            case R.id.menu_delete:  //this item has your app icon
                deleteAttendedDay = new DeleteAttendedDay();
                deleteAttendedDay.execute();
                return true;

            case R.id.menu_save:
                attendedDaySubmit();
                return true;

            default: return super.onOptionsItemSelected(item);
        }
    }

    @Override
    public boolean onPrepareOptionsMenu(Menu menu){
        if (edit.equals("1")) {
            menu.findItem(R.id.menu_delete).setEnabled(true);
            menu.findItem(R.id.menu_save).setEnabled(true);
        }
        return super.onPrepareOptionsMenu(menu);
    }

    public void attendedDaySubmit(){
        View focusView = null;
        temp_place = place.getText().toString();
        temp_activity = activity.getText().toString();
        if (TextUtils.isEmpty(temp_place)){
            place.setError(getString(R.string.error_field_required));
            focusView = place;
            focusView.requestFocus();
        }else if (TextUtils.isEmpty(temp_activity)){
            activity.setError(getString(R.string.error_field_required));
            focusView = activity;
            focusView.requestFocus();

        }else{
            mAttendedDayTask = new AttendedDayTask();
            mAttendedDayTask.execute();
        }
    }

    public void updateTimeRequest(){
        if (temp_time_out%100<temp_time_in%100 ||temp_time_out%100<temp_time_break%100 ){
            if ((temp_time_in%100 + temp_time_break%100)>60){
                temp_totaltime = temp_time_out - temp_time_in - temp_time_break-80;
            }else {
                temp_totaltime = temp_time_out - temp_time_in - temp_time_break - 40;
            }
        }else{
            temp_totaltime = temp_time_out - temp_time_in - temp_time_break;
        }
        if (temp_totaltime > 800){
            temp_overtime = temp_totaltime - 800;
        }else{
            temp_overtime = 0;
        }

        if (temp_totaltime/100 < 10 && temp_totaltime%100 < 10){
            totaltime.setText("0"+temp_totaltime/100 + ":0" + temp_totaltime%100);
        }else if(temp_totaltime/100 < 10){
            totaltime.setText("0"+temp_totaltime/100 + ":" + temp_totaltime%100);
        }else if(temp_totaltime%100 < 10){
            totaltime.setText(temp_totaltime/100 + ":0" + temp_totaltime%100);
        }else{
            totaltime.setText(temp_totaltime/100 + ":" + temp_totaltime%100);
        }

        if (temp_overtime/100 < 10 && temp_overtime%100 < 10){
            overtime.setText("0"+temp_overtime/100 + ":0" + temp_overtime%100);
        }else if(temp_overtime/100 < 10){
            overtime.setText("0"+temp_overtime/100 + ":" + temp_overtime%100);
        }else if(temp_overtime%100 < 10){
            overtime.setText(temp_overtime/100 + ":0" + temp_overtime%100);
        }else{
            overtime.setText(temp_overtime/100 + ":" + temp_overtime%100);
        }

    }

    public void getTimeIn(View v) {

        // Get Current Time
        final Calendar c = Calendar.getInstance();
        mHour = setHour(timed_in);
        mMinute = setMinutes(timed_in);

        // Launch Time Picker Dialog
        final TimePickerDialog timePickerDialog = new TimePickerDialog(this,
                new TimePickerDialog.OnTimeSetListener() {

                    @Override
                    public void onTimeSet(TimePicker view, int hourOfDay, int minute) {
                        timed_in = String.valueOf(hourOfDay)+":"+String.valueOf(minute);
                        int temp = hourOfDay*100 + minute;
                        if (temp_time_out > temp) {
                            temp_time_in = hourOfDay*100 + minute;
                            if (hourOfDay < 10 && minute < 10){
                                timed_in = "0"+hourOfDay + ":0" + minute;
                                time_in.setText(timed_in);
                            }else if(hourOfDay < 10){
                                timed_in = "0"+hourOfDay + ":" + minute;
                                time_in.setText(timed_in);
                            }else if(minute < 10){
                                timed_in = hourOfDay + ":0" + minute;
                                time_in.setText(timed_in);
                            }else{
                                timed_in = hourOfDay + ":" + minute;
                                time_in.setText(timed_in);
                            }
                            updateTimeRequest();
                        }else {
                            Toast.makeText(AttendedDay.this,"Time in must be lower then Time out",Toast.LENGTH_LONG).show();
                        }
                    }
                }, mHour, mMinute, false);
        timePickerDialog.show();
    }

    public void getTimeOut(View v) {

        // Get Current Time
        final Calendar c = Calendar.getInstance();
        mHour = setHour(timed_out);
        mMinute = setMinutes(timed_out);

        // Launch Time Picker Dialog
        TimePickerDialog timePickerDialog = new TimePickerDialog(this,
                new TimePickerDialog.OnTimeSetListener() {

                    @Override
                    public void onTimeSet(TimePicker view, int hourOfDay,
                                          int minute) {
                        timed_out = String.valueOf(hourOfDay)+":"+String.valueOf(minute);
                        int temp = hourOfDay*100 + minute;
                        if (temp_time_in < temp){
                            temp_time_out = hourOfDay*100 + minute;
                            if (hourOfDay < 10 && minute < 10){
                                timed_out = "0"+hourOfDay + ":0" + minute;
                                time_out.setText(timed_out);
                            }else if(hourOfDay < 10){
                                timed_out = "0"+hourOfDay + ":" + minute;
                                time_out.setText(timed_out);
                            }else if(minute < 10){
                                timed_out = hourOfDay + ":0" + minute;
                                time_out.setText(timed_out);
                            }else{
                                timed_out = hourOfDay + ":" + minute;
                                time_out.setText(timed_out);
                            }
                            updateTimeRequest();
                        }else{
                            Toast.makeText(AttendedDay.this,"Time out must be greather then Time in",Toast.LENGTH_LONG).show();
                        }
                    }
                }, mHour, mMinute, false);
        timePickerDialog.show();
    }

    public void getTimeBreak(View v) {

        // Get Current Time
        final Calendar c = Calendar.getInstance();
        mHour = setHour(timed_break);
        mMinute = setMinutes(timed_break);

        // Launch Time Picker Dialog
        TimePickerDialog timePickerDialog = new TimePickerDialog(this,
                new TimePickerDialog.OnTimeSetListener() {

                    @Override
                    public void onTimeSet(TimePicker view, int hourOfDay,
                                          int minute) {
                        timed_break = String.valueOf(hourOfDay)+":"+String.valueOf(minute);
                        temp_time_break = hourOfDay*100 + minute;
                        if (hourOfDay < 10 && minute < 10){
                            timed_break = "0"+hourOfDay + ":0" + minute;
                            time_break.setText(timed_break);
                        }else if(hourOfDay < 10){
                            timed_break = "0"+hourOfDay + ":" + minute;
                            time_break.setText(timed_break);
                        }else if(minute < 10){
                            timed_break = hourOfDay + ":0" + minute;
                            time_break.setText(timed_break);
                        }else{
                            timed_break = hourOfDay + ":" + minute;
                            time_break.setText(timed_break);
                        }
                        updateTimeRequest();
                    }
                }, mHour, mMinute, false);
        timePickerDialog.show();
    }

    public void Logout(){
        SharedPreferences sharedPreferences;
        sharedPreferences = getSharedPreferences("Login",Context.MODE_PRIVATE);
        SharedPreferences.Editor editor = sharedPreferences.edit();
        editor.putString(Config.TAG_TOKEN,null);
        editor.commit();
        Intent intent = new Intent(this,LoginActivity.class);
        intent.setFlags(Intent.FLAG_ACTIVITY_NEW_TASK|Intent.FLAG_ACTIVITY_CLEAR_TASK);
        startActivity(intent);
    }

    public class AttendedDayTask extends AsyncTask<Void, Void, Boolean> {
        ProgressDialog loading;
        AttendedDayTask() {

        }

        protected void onPreExecute() {
            super.onPreExecute();
            loading = ProgressDialog.show(AttendedDay.this,null,"Saving to database",false,true);
        }

        @Override
        protected Boolean doInBackground(Void... params) {
            try {
                // Simulate network access.
                HashMap<String,String> param = new HashMap<>();
                SharedPreferences sharedPreferences;
                sharedPreferences = getSharedPreferences("Login", Context.MODE_PRIVATE);
                String token = sharedPreferences.getString(Config.TAG_TOKEN,"");
                String id = sharedPreferences.getString(Config.TAG_ID,"");

                param.put(Config.TAG_TOKEN,token);
                param.put(Config.TAG_ID,id);
                param.put(Config.TAG_DATE,i_date2);
                param.put(Config.TAG_TIME_IN,Integer.toString(temp_time_in));
                param.put(Config.TAG_TIME_OUT,Integer.toString(temp_time_out));
                param.put(Config.TAG_TIME_BREAK,Integer.toString(temp_time_break));
                param.put(Config.TAG_OVERTIME,Integer.toString(temp_overtime));
                param.put(Config.TAG_TOTALTIME,Integer.toString(temp_totaltime));
                param.put(Config.TAG_ACTIVITY,temp_activity);
                param.put(Config.TAG_PLACE,temp_place);

                RequestHandler rh = new RequestHandler();
                String res = rh.sendPostRequest(Config.URL_POST_ATTENDANCE, param);
                JSON_STRING = res;
                Thread.sleep(3000);
            } catch (InterruptedException e) {
                return false;
            }

            return true;
        }

        @Override
        protected void onPostExecute(final Boolean success) {
            mAttendedDayTask = null;
            if (success) {
                JSONObject jsonObject = null;
                try {
                    jsonObject = new JSONObject(JSON_STRING);
                    String message = jsonObject.getString(Config.TAG_MESSAGE);
                    String status = jsonObject.getString(Config.TAG_STATUS);
                    if (status.equals("401")){
                        Toast.makeText(AttendedDay.this,message,Toast.LENGTH_LONG).show();
                        Logout();
                    }
                    Toast.makeText(AttendedDay.this,message,Toast.LENGTH_LONG).show();
                }catch (JSONException e) {
                    e.printStackTrace();
                }
            } else {
                Toast.makeText(AttendedDay.this,"Connection timed out",Toast.LENGTH_LONG).show();
            }
            loading.dismiss();
            Intent intent = new Intent(AttendedDay.this,WriteAttendance.class);
            intent.putExtra(Config.TAG_MONTH2,month);
            intent.putExtra(Config.TAG_YEAR,year);
            intent.setFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);
            intent.putExtra(Config.TAG_EDIT,edit);
            startActivity(intent);
        }

        @Override
        protected void onCancelled() {
            loading.dismiss();
            mAttendedDayTask = null;
        }
    }

    public class DeleteAttendedDay extends AsyncTask<Void, Void, Boolean> {
        ProgressDialog loading;
        DeleteAttendedDay() {

        }

        protected void onPreExecute() {
            super.onPreExecute();
            loading = ProgressDialog.show(AttendedDay.this,null,"Deleting record",false,true);
        }

        @Override
        protected Boolean doInBackground(Void... params) {
            try {
                // Simulate network access.
                HashMap<String,String> param = new HashMap<>();
                SharedPreferences sharedPreferences;
                sharedPreferences = getSharedPreferences("Login", Context.MODE_PRIVATE);
                String token = sharedPreferences.getString(Config.TAG_TOKEN,"");
                String id = sharedPreferences.getString(Config.TAG_ID,"");

                param.put(Config.TAG_TOKEN,token);
                param.put(Config.TAG_ID,id);
                param.put(Config.TAG_DATE,i_date2);

                RequestHandler rh = new RequestHandler();
                String res = rh.sendPostRequest(Config.URL_DELETE_ATTENDANCE, param);
                JSON_STRING = res;
                Thread.sleep(3000);
            } catch (InterruptedException e) {
                return false;
            }

            return true;
        }

        @Override
        protected void onPostExecute(final Boolean success) {
            mAttendedDayTask = null;
            if (success) {
                JSONObject jsonObject = null;
                try {
                    jsonObject = new JSONObject(JSON_STRING);
                    String message = jsonObject.getString(Config.TAG_MESSAGE);
                    String status = jsonObject.getString(Config.TAG_STATUS);
                    Toast.makeText(AttendedDay.this,message,Toast.LENGTH_LONG).show();
                    if (status.equals("401")){
                        Logout();
                    }
                }catch (JSONException e) {
                    e.printStackTrace();
                }
            } else {
                Toast.makeText(AttendedDay.this,"Connection timed out",Toast.LENGTH_LONG).show();
            }
            loading.dismiss();
            Intent intent = new Intent(AttendedDay.this,WriteAttendance.class);
            intent.setFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);
            intent.putExtra(Config.TAG_EDIT,edit);
            intent.putExtra(Config.TAG_MONTH2,month);
            intent.putExtra(Config.TAG_YEAR,year);
            startActivity(intent);
        }

        @Override
        protected void onCancelled() {
            loading.dismiss();
            mAttendedDayTask = null;
        }
    }
}
