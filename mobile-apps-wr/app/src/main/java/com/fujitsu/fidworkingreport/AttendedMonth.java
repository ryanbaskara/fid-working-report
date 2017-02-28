package com.fujitsu.fidworkingreport;


import android.app.ProgressDialog;
import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.os.AsyncTask;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.text.TextUtils;
import android.view.KeyEvent;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.view.inputmethod.EditorInfo;
import android.widget.AutoCompleteTextView;
import android.widget.TextView;
import android.widget.Toast;

import org.json.JSONException;
import org.json.JSONObject;

import java.util.HashMap;

public class AttendedMonth extends AppCompatActivity {

    private String custName, pName, woNumber,edit,i_customer_name,i_project_name,i_wo_number,i_date,i_total_time,i_overtime;
    private AutoCompleteTextView customer_name,project_name,wo_number;
    private PostInformation postInformation = null;
    String JSON_STRING;
    private String year,month;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_attended_month);
        customer_name = (AutoCompleteTextView)findViewById(R.id.customer_name);
        project_name = (AutoCompleteTextView)findViewById(R.id.project_name);
        wo_number = (AutoCompleteTextView)findViewById(R.id.wo_number);
        TextView overtime_view = (TextView)findViewById(R.id.overtime);
        TextView totaltime_view = (TextView)findViewById(R.id.totaltime);
        TextView viewName = (TextView)findViewById(R.id.viewName);
        TextView viewPosition = (TextView)findViewById(R.id.viewPosition);

        SharedPreferences sharedPreferences;
        sharedPreferences = getSharedPreferences("Login", Context.MODE_PRIVATE);
        String id_user = sharedPreferences.getString(Config.TAG_ID,"");
        String name = sharedPreferences.getString(Config.TAG_NAME,"");
        String position = sharedPreferences.getString(Config.TAG_POSITION,"");
        getDataIntent();

        getSupportActionBar().setTitle(i_date.substring(3));
        customer_name.setText(i_customer_name);
        project_name.setText(i_project_name);
        wo_number.setText(i_wo_number);
        overtime_view.setText(i_overtime);
        totaltime_view.setText(i_total_time);
        viewName.setText(name+" ("+id_user+")");
        viewPosition.setText(position);

        customer_name.setOnEditorActionListener(new TextView.OnEditorActionListener() {
            @Override
            public boolean onEditorAction(TextView textView, int id, KeyEvent keyEvent) {
                if (id == R.id.ime_customer_name ) {
                    View focusView = project_name;
                    focusView.requestFocus();
                    return true;
                }
                return false;
            }
        });
        project_name.setOnEditorActionListener(new TextView.OnEditorActionListener() {
            @Override
            public boolean onEditorAction(TextView textView, int id, KeyEvent keyEvent) {
                if (id == R.id.ime_project_name ) {
                    View focusView = wo_number;
                    focusView.requestFocus();
                    return true;
                }
                return false;
            }
        });
        wo_number.setOnEditorActionListener(new TextView.OnEditorActionListener() {
            @Override
            public boolean onEditorAction(TextView textView, int id, KeyEvent keyEvent) {
                if (id == R.id.ime_wo_number || id == EditorInfo.IME_NULL) {
                    saveInformation();
                    return true;
                }
                return false;
            }
        });
    }

    private void getDataIntent(){
        Intent i = getIntent();
        edit = i.getStringExtra(Config.TAG_EDIT);
        month = i.getStringExtra(Config.TAG_MONTH);
        year =i.getStringExtra(Config.TAG_YEAR);
        i_customer_name = i.getStringExtra(Config.KEY_CUSTOMER_NAME);
        i_project_name = i.getStringExtra(Config.KEY_PROJECT_NAME);
        i_wo_number = i.getStringExtra(Config.KEY_WO_NUMBER);
        i_date = i.getStringExtra(Config.TAG_DATE);
        i_total_time = i.getStringExtra(Config.TAG_TOTALTIME);
        i_overtime = i.getStringExtra(Config.TAG_OVERTIME);
    }

    public void saveInformation(){
        View focusView = null;

        custName = customer_name.getText().toString();
        pName = project_name.getText().toString();
        woNumber = wo_number.getText().toString();

        if (TextUtils.isEmpty(custName)){
            customer_name.setError(getString(R.string.error_field_required));
            focusView = customer_name;
            focusView.requestFocus();
        }
        if (TextUtils.isEmpty(pName)){
            project_name.setError(getString(R.string.error_field_required));
            focusView = project_name;
            focusView.requestFocus();
        }
        if (TextUtils.isEmpty(woNumber)){
            wo_number.setError(getString(R.string.error_field_required));
            focusView = wo_number;
            focusView.requestFocus();
        }else {
            postInformation = new PostInformation();
            postInformation.execute((Void) null);
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

    @Override
    public boolean onCreateOptionsMenu(Menu menu){
        getMenuInflater().inflate(R.menu.attended_month, menu);
        return super.onCreateOptionsMenu(menu);
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item){

        switch(item.getItemId()){
            case R.id.menu_save:
                saveInformation();
                return true;

            default: return super.onOptionsItemSelected(item);
        }
    }

    @Override
    public boolean onPrepareOptionsMenu(Menu menu){
        menu.findItem(R.id.menu_save).setEnabled(true);
        return super.onPrepareOptionsMenu(menu);
    }

    public class PostInformation extends AsyncTask<Void, Void, Boolean> {
        private String token,id;
        PostInformation() {
            SharedPreferences sharedPreferences;
            sharedPreferences = getSharedPreferences("Login", Context.MODE_PRIVATE);
            token = sharedPreferences.getString(Config.TAG_TOKEN,"");
            id = sharedPreferences.getString(Config.TAG_ID,"");
        }
        ProgressDialog loading;
        @Override
        protected void onPreExecute() {
            super.onPreExecute();
            loading = ProgressDialog.show(AttendedMonth.this,null,"Saving to database",false,true);
        }

        @Override
        protected Boolean doInBackground(Void... params) {
            // TODO: attempt authentication against a network service.
            try {
                HashMap<String,String> param = new HashMap<>();
                param.put(Config.TAG_TOKEN,token);
                param.put(Config.TAG_ID,id);
                param.put(Config.KEY_CUSTOMER_NAME,custName);
                param.put(Config.KEY_PROJECT_NAME,pName);
                param.put(Config.KEY_WO_NUMBER,woNumber);
                param.put(Config.TAG_DATE,year+"-"+month+"-01");
                RequestHandler rh = new RequestHandler();
                String res = rh.sendPostRequest(Config.URL_POST_MONTH, param);
                JSON_STRING = res;
                Thread.sleep(3000);
            } catch (InterruptedException e) {
                return false;
            }

            return true;
        }

        @Override
        protected void onPostExecute(final Boolean success) {
            loading.dismiss();
            postInformation = null;
            if (success) {
                JSONObject jsonObject = null;
                try {
                    jsonObject = new JSONObject(JSON_STRING);
                    String message = jsonObject.getString(Config.TAG_MESSAGE);
                    String status = jsonObject.getString(Config.TAG_STATUS);
                    Toast.makeText(AttendedMonth.this,message,Toast.LENGTH_LONG).show();
                    if (status.equals("200")){
                        Intent intent = new Intent(AttendedMonth.this,WriteAttendance.class);
                        intent.setFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);
                        intent.putExtra(Config.TAG_MONTH2,month);
                        intent.putExtra(Config.TAG_YEAR,year);
                        intent.putExtra(Config.TAG_EDIT,edit);
                        startActivity(intent);
                    } else if (status.equals("401")){
                        Toast.makeText(AttendedMonth.this,message,Toast.LENGTH_LONG).show();
                        Logout();
                    }
                }catch (JSONException e) {
                    e.printStackTrace();
                }
            } else {
                Toast.makeText(AttendedMonth.this,"Connection timed out",Toast.LENGTH_LONG).show();
            }
        }

        @Override
        protected void onCancelled() {
            loading.dismiss();
            postInformation = null;
        }
    }
}
