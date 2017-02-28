package com.fujitsu.fidworkingreport;

import android.app.ProgressDialog;
import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.graphics.LinearGradient;
import android.os.AsyncTask;
import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
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

public class ViewAttendance extends AppCompatActivity implements ListView.OnItemClickListener {

    private ListView listView;

    private String JSON_STRING;
    private String token, id_user, name=null;
    private int year;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        //get Token from local storage
        SharedPreferences sharedPreferences;
        sharedPreferences = getSharedPreferences("Login", Context.MODE_PRIVATE);
        token = sharedPreferences.getString(Config.TAG_TOKEN,"");
        id_user = sharedPreferences.getString(Config.TAG_ID,"");
        name = sharedPreferences.getString(Config.TAG_NAME,"");
        String position = sharedPreferences.getString(Config.TAG_POSITION,"");

        setContentView(R.layout.activity_list);
        listView = (ListView) findViewById(R.id.listView);
        listView.setOnItemClickListener(this);
        java.util.Date date = new Date();
        Calendar calendar = Calendar.getInstance();
        calendar.setTime(date);
        Intent i = getIntent();
        year =Integer.parseInt(i.getStringExtra(Config.TAG_YEAR));

        TextView viewName = (TextView)findViewById(R.id.viewName);
        TextView viewPosition = (TextView)findViewById(R.id.viewPosition);
        viewName.setText(name+" ("+id_user+")");
        viewPosition.setText(position);

        Toolbar toolbar = (Toolbar) findViewById(R.id.toolbarListDay);

        getSupportActionBar().setTitle(String.valueOf(year));

        getJSON();
    }
    @Override
    public boolean onCreateOptionsMenu(Menu menu){
        getMenuInflater().inflate(R.menu.select_month, menu);
        return super.onCreateOptionsMenu(menu);
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item){

        switch(item.getItemId()){
            case R.id.prev:
                year = year - 1;
                Intent intent = new Intent(this, ViewAttendance.class);
                intent.putExtra(Config.TAG_YEAR,String.valueOf(year));
                intent.setFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);
                startActivity(intent);
                return true;
            case R.id.next:
                year = year + 1;
                Intent intent2 = new Intent(this, ViewAttendance.class);
                intent2.putExtra(Config.TAG_YEAR,String.valueOf(year));
                intent2.setFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);
                startActivity(intent2);
                return true;
            default: return super.onOptionsItemSelected(item);
        }
    }

    @Override
    public boolean onPrepareOptionsMenu(Menu menu){
        menu.findItem(R.id.prev).setEnabled(true);
        menu.findItem(R.id.next).setEnabled(true);
        return super.onPrepareOptionsMenu(menu);
    }

    private void showMonth(){
        JSONObject jsonObject = null;
        ArrayList<HashMap<String,String>> list = new ArrayList<HashMap<String, String>>();
        try {
            jsonObject = new JSONObject(JSON_STRING);
            JSONArray result = jsonObject.getJSONArray("data");
            String status = jsonObject.getString(Config.TAG_STATUS);
            if (status.equals("200")) {
                for (int i = 0; i < result.length(); i++) {
                    JSONObject jo = result.getJSONObject(i);
                    String month = jo.getString(Config.TAG_MONTH);
                    String month_name = jo.getString(Config.TAG_MONTH2);
                    String date = jo.getString(Config.TAG_DATE);
                    String status_month = jo.getString(Config.TAG_STATUS);
                    String attended = jo.getString(Config.TAG_ATTENDED);

                    HashMap<String, String> dataMonth = new HashMap<>();
                    dataMonth.put(Config.TAG_MONTH, month);
                    dataMonth.put(Config.TAG_NAME, month_name);
                    dataMonth.put(Config.TAG_DATE, date);
                    dataMonth.put(Config.TAG_STATUS,status_month);
                    dataMonth.put(Config.TAG_ATTENDED,"Attended: "+attended+" days");
                    String customer_name=null, project_name=null, wo_number=null,totaltime=null;
                    if (status_month.equals("1")){
                        customer_name = jo.getString(Config.KEY_CUSTOMER_NAME);
                        project_name = jo.getString(Config.KEY_PROJECT_NAME);
                        wo_number = jo.getString(Config.KEY_WO_NUMBER);
                        String overtime = jo.getString(Config.TAG_OVERTIME);
                        totaltime ="Total Time: " +jo.getString(Config.TAG_TOTALTIME)+" (Overtime: "+overtime+")";
                    }

                    dataMonth.put(Config.KEY_CUSTOMER_NAME, customer_name);
                    dataMonth.put(Config.KEY_PROJECT_NAME, project_name);
                    dataMonth.put(Config.KEY_WO_NUMBER, wo_number);
                    dataMonth.put(Config.TAG_TIME_INFORMATION, totaltime);
                    list.add(dataMonth);
                }
            }else if(status.equals("401")){
                String message = jsonObject.getString(Config.TAG_MESSAGE);
                Toast.makeText(ViewAttendance.this,message,Toast.LENGTH_LONG).show();
                Logout();
            }
        } catch (JSONException e) {
            e.printStackTrace();
        }

        SimpleAdapter adapter2 = new Adapter_ViewAttendance(this, list,
                R.layout.item_list, new String[] { Config.TAG_NAME,Config.TAG_DATE,Config.TAG_ATTENDED,Config.KEY_CUSTOMER_NAME,Config.KEY_PROJECT_NAME,Config.KEY_WO_NUMBER,Config.TAG_TIME_INFORMATION,Config.TAG_STATUS}, new
                int[] {R.id.name, R.id.date,R.id.attended,R.id.time,R.id.customer_name,R.id.project_name,R.id.wo_number });

        listView.setAdapter(adapter2);
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
                loading = ProgressDialog.show(ViewAttendance.this,null,"Sync Data",false,true);
            }

            @Override
            protected void onPostExecute(String s) {
                super.onPostExecute(s);
                loading.dismiss();
                JSON_STRING = s;
                showMonth();
            }

            @Override
            protected String doInBackground(Void... params) {

                String param = Config.TAG_ID+"="+id_user+"&"+Config.TAG_TOKEN+"="+token+"&"+Config.TAG_YEAR+"="+year;
                RequestHandler rh = new RequestHandler();
                String s = rh.sendGetRequestParam(Config.URL_SELECT_MONTH,param);
                return s;
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
        Intent intent = new Intent(this, WriteAttendance.class);
        HashMap<String,String> map =(HashMap)parent.getItemAtPosition(position);
        String month = map.get(Config.TAG_MONTH).toString();

        intent.putExtra(Config.TAG_MONTH2,month);
        intent.putExtra(Config.TAG_YEAR,String.valueOf(year));
        intent.putExtra(Config.TAG_EDIT,"0");
        intent.setFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);
        startActivity(intent);
    }
}