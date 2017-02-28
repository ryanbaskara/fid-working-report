package com.fujitsu.fidworkingreport;

import android.app.ProgressDialog;
import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.os.AsyncTask;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.support.v7.widget.Toolbar;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ListView;
import android.widget.SimpleAdapter;
import android.widget.TextView;
import android.widget.Toast;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.Calendar;
import java.util.Date;
import java.util.HashMap;

public class WriteAttendance extends AppCompatActivity implements ListView.OnItemClickListener {

    private ListView listView;

    private String JSON_STRING, JSON_CHECK;
    private String edit,token, id_user, name=null, position=null;
    private String year=null,month=null,customer_name=null,project_name=null,wo_number=null,date=null,totaltime=null,overtime=null;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        //get Token from local storage
        SharedPreferences sharedPreferences;
        sharedPreferences = getSharedPreferences("Login", Context.MODE_PRIVATE);
        token = sharedPreferences.getString(Config.TAG_TOKEN,"");
        id_user = sharedPreferences.getString(Config.TAG_ID,"");
        name = sharedPreferences.getString(Config.TAG_NAME,"");
        position = sharedPreferences.getString(Config.TAG_POSITION,"");

        setContentView(R.layout.activity_list);
        listView = (ListView) findViewById(R.id.listView);
        TextView viewName = (TextView)findViewById(R.id.viewName);
        TextView viewPosition = (TextView)findViewById(R.id.viewPosition);
        viewName.setText(name+" ("+id_user+")");
        viewPosition.setText(position);


        java.util.Date date = new Date();
        Calendar calendar = Calendar.getInstance();
        calendar.setTime(date);
        Intent i = getIntent();
        edit = i.getStringExtra(Config.TAG_EDIT);
        if (!(i.getStringExtra(Config.TAG_MONTH2)).equals("0")){
            year = i.getStringExtra(Config.TAG_YEAR);
            month = i.getStringExtra(Config.TAG_MONTH2);
        }else{
            month = String.valueOf((calendar.get(Calendar.MONTH)+1)%12);
            if ((calendar.get(Calendar.MONTH)+1)/12==1){
                year = String.valueOf(calendar.get(Calendar.YEAR)+1);
            }else{
                year = String.valueOf(calendar.get(Calendar.YEAR));
            }
        }
        listView.setOnItemClickListener(this);
        Toolbar toolbar = (Toolbar) findViewById(R.id.toolbarListDay);
        getSupportActionBar().setTitle(monthName(month)+" "+year);

        getJSON();
    }
    public String monthName(String month){
        int m = Integer.parseInt(month);
        String[] month_name = {"","January","February","March","April","May","June","July","August","September","October","November","December"};
        return month_name[m];
    }
    @Override
    public boolean onCreateOptionsMenu(Menu menu){
    if (edit.equals("1")) {
        getMenuInflater().inflate(R.menu.list_day, menu);
    }
        return super.onCreateOptionsMenu(menu);
    }
    @Override
    public boolean onOptionsItemSelected(MenuItem item){

        int temp_month = Integer.parseInt(month);
        int tmp_year = Integer.parseInt(year);
        switch(item.getItemId()){
            case R.id.prev:
                if (temp_month==1){
                    temp_month = 12;
                    tmp_year = tmp_year -1;
                }else{
                    temp_month = temp_month - 1;
                }

                Intent intent1 = new Intent(this, WriteAttendance.class);
                intent1.putExtra(Config.TAG_EDIT,String.valueOf(edit));
                intent1.putExtra(Config.TAG_YEAR,String.valueOf(tmp_year));
                intent1.putExtra(Config.TAG_MONTH2,String.valueOf(temp_month));
                intent1.setFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);
                startActivity(intent1);
                return true;
            case R.id.next:
                if (temp_month==12){
                    temp_month = 1;
                    tmp_year = tmp_year +1;
                }else{
                    temp_month = temp_month + 1;
                }

                Intent intent2 = new Intent(this, WriteAttendance.class);
                intent2.putExtra(Config.TAG_EDIT,String.valueOf(edit));
                intent2.putExtra(Config.TAG_YEAR,String.valueOf(tmp_year));
                intent2.putExtra(Config.TAG_MONTH2,String.valueOf(temp_month));
                intent2.setFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);
                startActivity(intent2);
                return true;

            case R.id.menu_item_edit:   //this item has your app icon
                Intent intent = new Intent(WriteAttendance.this, AttendedMonth.class);
                intent.putExtra(Config.TAG_DATE,date);
                intent.putExtra(Config.TAG_EDIT, edit);
                intent.putExtra(Config.TAG_MONTH, month);
                intent.putExtra(Config.TAG_YEAR, year);
                intent.putExtra(Config.KEY_CUSTOMER_NAME, customer_name);
                intent.putExtra(Config.KEY_PROJECT_NAME, project_name);
                intent.putExtra(Config.KEY_WO_NUMBER, wo_number);
                intent.putExtra(Config.TAG_TOTALTIME,totaltime);
                intent.putExtra(Config.TAG_OVERTIME,overtime);
                startActivity(intent);
                return true;

            default: return super.onOptionsItemSelected(item);
        }
    }

    @Override
    public boolean onPrepareOptionsMenu(Menu menu){
    if (edit.equals("1")){
        menu.findItem(R.id.menu_item_edit).setEnabled(true);
        menu.findItem(R.id.next).setEnabled(true);
        menu.findItem(R.id.prev).setEnabled(true);
    }

        return super.onPrepareOptionsMenu(menu);
    }
    private void showDay(){
        JSONObject jsonObject = null;
        ArrayList<HashMap<String,String>> list = new ArrayList<HashMap<String, String>>();
        try {
            jsonObject = new JSONObject(JSON_STRING);
            JSONArray result = jsonObject.getJSONArray("data");
            String status_fetch = jsonObject.getString(Config.TAG_STATUS);
            if (status_fetch.equals("200")){
                date = result.getJSONObject(0).getString(Config.TAG_DATE);
                for(int i = 0; i<result.length(); i++){
                    JSONObject jo = result.getJSONObject(i);
                    String day = jo.getString(Config.TAG_DAY_NAME);
                    String date = jo.getString(Config.TAG_DATE);
                    String status = jo.getString(Config.TAG_STATUS);
                    String date2 = jo.getString(Config.TAG_DATE2);
                    String time=null;
                    String time_in = "";
                    String time_out = "";
                    String time_break = "";
                    String place = "";
                    String activity = "";
                    String overtime="", totaltime="";
                    String information=null;
                    if (status.equals("1")) {
                        time = jo.getString(Config.TAG_TIME_IN)+" - "+jo.getString(Config.TAG_TIME_OUT);
                        information = jo.getString(Config.TAG_PLACE)+" ("+jo.getString(Config.TAG_ACTIVITY)+")";
                        time_in = jo.getString(Config.TAG_TIME_IN);
                        time_out = jo.getString(Config.TAG_TIME_OUT);
                        time_break = jo.getString(Config.TAG_TIME_BREAK);
                        place = jo.getString(Config.TAG_PLACE);
                        overtime = jo.getString(Config.TAG_OVERTIME);
                        totaltime = jo.getString(Config.TAG_TOTALTIME);
                        activity = jo.getString(Config.TAG_ACTIVITY);
                    }else{
                        time = "";
                        information = "";
                    }

                    HashMap<String,String> dataDay = new HashMap<>();
                    dataDay.put(Config.TAG_DAY_NAME,day);
                    dataDay.put(Config.TAG_DATE,date);
                    dataDay.put(Config.TAG_DATE2,date2);
                    dataDay.put(Config.TAG_TIME_IN_OUT,time);
                    dataDay.put(Config.TAG_TIME_IN,time_in);
                    dataDay.put(Config.TAG_TIME_OUT,time_out);
                    dataDay.put(Config.TAG_TIME_BREAK,time_break);
                    dataDay.put(Config.TAG_PLACE,place);
                    dataDay.put(Config.TAG_ACTIVITY,activity);
                    dataDay.put(Config.TAG_TIME_INFORMATION,information);
                    dataDay.put(Config.TAG_STATUS,status);
                    dataDay.put(Config.TAG_TOTALTIME,totaltime);
                    dataDay.put(Config.TAG_OVERTIME,overtime);
                    list.add(dataDay);
                }
            }else if (status_fetch.equals("401")){
                String message = jsonObject.getString(Config.TAG_MESSAGE);
                Toast.makeText(WriteAttendance.this,message,Toast.LENGTH_LONG).show();
                Logout();
            }

        } catch (JSONException e) {
            e.printStackTrace();
        }

        SimpleAdapter adapter2 = new CustomSimpleAdapter(this, list,
                R.layout.item_list, new String[] { Config.TAG_DAY_NAME,Config.TAG_DATE,Config.TAG_TIME_IN_OUT,Config.TAG_TIME_INFORMATION,Config.TAG_STATUS}, new
                int[] {R.id.day, R.id.date, R.id.time_in_out,R.id.time_information,R.id.day});

        listView.setAdapter(adapter2);
    }
    private void dataMonth(){
        JSONObject jsonObject2 = null;
        try {
            jsonObject2 = new JSONObject(JSON_CHECK);
            String status = jsonObject2.getString(Config.TAG_STATUS);
            if (status.equals("200")){
                customer_name = jsonObject2.getString(Config.KEY_CUSTOMER_NAME);
                project_name = jsonObject2.getString(Config.KEY_PROJECT_NAME);
                wo_number = jsonObject2.getString(Config.KEY_WO_NUMBER);
                totaltime = "Total Time: " + jsonObject2.getString(Config.TAG_TOTALTIME) + " h";
                overtime = "Overtime: " + jsonObject2.getString(Config.TAG_OVERTIME) + " h";
            }else if (status.equals("401")){
                String message = jsonObject2.getString(Config.TAG_MESSAGE);
                Toast.makeText(WriteAttendance.this,message,Toast.LENGTH_LONG).show();
                Logout();
            }else{
                totaltime = "Total Time: 00:00 h";
                overtime = "Overtime: 00:00 h";
            }
        } catch (JSONException e) {
            e.printStackTrace();
        }
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
    private void getJSON(){
        class GetJSON extends AsyncTask<Void,Void,String>{

            ProgressDialog loading;
            @Override
            protected void onPreExecute() {
                super.onPreExecute();
                loading = ProgressDialog.show(WriteAttendance.this,null,"Sync Data",false,true);
            }

            @Override
            protected void onPostExecute(String s) {
                super.onPostExecute(s);
                loading.dismiss();
                JSON_STRING = s;
                dataMonth();
                showDay();
            }

            @Override
            protected String doInBackground(Void... params) {
                String param = Config.TAG_ID+"="+id_user+"&"+Config.TAG_TOKEN+"="+token+"&year="+year+"&month="+month;
                String param_checked = Config.TAG_ID+"="+id_user+"&"+Config.TAG_TOKEN+"="+token+"&"+Config.TAG_MONTH+"="+month+"&"+Config.TAG_YEAR+"="+year;
                RequestHandler rh = new RequestHandler();
                String s = rh.sendGetRequestParam(Config.URL_GET_LIST_DAY,param);
                RequestHandler rh_check = new RequestHandler();
                JSON_CHECK = rh_check.sendGetRequestParam(Config.URL_CHECK_MONTH, param_checked);
                return  s;
            }

            @Override
            protected void onCancelled() {
                loading.dismiss();
            }
        }
        GetJSON gj = new GetJSON();
        gj.execute();
    }

    @Override
    public void onItemClick(AdapterView<?> parent, View view, int position, long id) {

        Intent intent = new Intent(this, AttendedDay.class);

        HashMap<String,String> map =(HashMap)parent.getItemAtPosition(position);
        String date2 = map.get(Config.TAG_DATE2).toString();
        String date = map.get(Config.TAG_DATE).toString();
        String status = map.get(Config.TAG_STATUS).toString();
        String time_in = map.get(Config.TAG_TIME_IN).toString();
        String time_out = map.get(Config.TAG_TIME_OUT).toString();
        String time_break = map.get(Config.TAG_TIME_BREAK).toString();
        String activity = map.get(Config.TAG_ACTIVITY).toString();
        String place = map.get(Config.TAG_PLACE).toString();
        String overtime = map.get(Config.TAG_OVERTIME).toString();
        String totaltime = map.get(Config.TAG_TOTALTIME).toString();

        intent.putExtra(Config.TAG_DATE,date);
        intent.putExtra(Config.TAG_DATE2,date2);
        intent.putExtra(Config.TAG_TIME_IN,time_in);
        intent.putExtra(Config.TAG_TIME_OUT,time_out);
        intent.putExtra(Config.TAG_TIME_BREAK,time_break);
        intent.putExtra(Config.TAG_STATUS,status);
        intent.putExtra(Config.TAG_PLACE,place);
        intent.putExtra(Config.TAG_ACTIVITY,activity);
        intent.putExtra(Config.TAG_TOTALTIME,totaltime);
        intent.putExtra(Config.TAG_OVERTIME,overtime);
        intent.putExtra(Config.TAG_EDIT,edit);
        intent.putExtra(Config.TAG_MONTH2,month);
        intent.putExtra(Config.TAG_YEAR,year);
        startActivity(intent);
    }
}