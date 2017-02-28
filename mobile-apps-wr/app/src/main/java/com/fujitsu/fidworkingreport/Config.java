package com.fujitsu.fidworkingreport;


public class Config {

    private static final String BASE_URL = "http://id-fujitsu.com/api-fid-wr/";
    public static final String URL_LOGIN = BASE_URL + "auth";
    public static final String URL_CHECK_MONTH = BASE_URL + "view-month-attended-form?";
    public static final String URL_POST_MONTH = BASE_URL + "attended-month";
    public static final String URL_POST_ATTENDANCE = BASE_URL + "attended-day";
    public static final String URL_GET_LIST_DAY = BASE_URL + "data-month?";
    public static final String URL_SELECT_MONTH = BASE_URL + "select-month?";
    public static final String URL_DELETE_ATTENDANCE = BASE_URL + "delete-attended-day";
    //LOGIN
    //request
    public static final String KEY_USERNAME = "login_id";
    public static final String KEY_PASSWORD = "password";
    //respon
    public static final String TAG_STATUS = "status";
    public static final String TAG_ID = "id";
    public static final String TAG_NAME = "name";
    public static final String TAG_POSITION = "position";
    public static final String TAG_TOKEN = "token";
    public static final String TAG_MESSAGE = "message";

    //Day
    public static final String TAG_DAY_NAME = "day";
    public static final String TAG_DATE = "date";
    public static final String TAG_DATE2 = "date2";
    public static final String TAG_YEAR = "year";
    public static final String TAG_MONTH = "month";
    public static final String TAG_MONTH2 = "month2";
    public static final String TAG_TIME_IN = "time_in";
    public static final String TAG_TIME_OUT = "time_out";
    public static final String TAG_TIME_BREAK = "time_break";
    public static final String TAG_TOTALTIME = "totaltime";
    public static final String TAG_OVERTIME = "overtime";
    public static final String TAG_PLACE = "place";
    public static final String TAG_ACTIVITY = "activity";
    public static final String TAG_TIME_INFORMATION = "time_information";
    public static final String TAG_TIME_IN_OUT = "in_out";

    //MONTH
    public static final String KEY_CUSTOMER_NAME = "customer_name";
    public static final String KEY_PROJECT_NAME = "project_name";
    public static final String KEY_WO_NUMBER = "wo_number";
    public static final String TAG_ATTENDED = "attended";
    public static final String TAG_EDIT = "edit";


    public static final String TAG_CONTENT = "content";
    public static final String TAG_TITLE = "title";
    public static final String TAG_DEVICE_TOKEN = "device_token";

}
