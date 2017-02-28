package com.fujitsu.fidworkingreport;

import android.app.ActionBar;
import android.content.Context;
import android.graphics.Color;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.LinearLayout;
import android.widget.RelativeLayout;
import android.widget.SimpleAdapter;
import android.widget.TableLayout;
import android.widget.TextView;

import java.util.List;
import java.util.Map;

/**
 * Created by Ryan Baskara on 29/07/2016.
 */
public class Adapter_ViewAttendance extends SimpleAdapter {

    private List<Map<String, Object>> itemList;
    private Context mContext;

    public Adapter_ViewAttendance(Context context, List<? extends Map<String, ?>> data,
                                  int resource, String[] from, int[] to) {
        super(context, data, resource, from, to);

        this.itemList = (List<Map<String, Object>>) data;
        this.mContext = context;
    }

    /* A Static class for holding the elements of each List View Item
     * This is created as per Google UI Guideline for faster performance */
    class ViewHolder {
        TextView name;
        TextView date;
        TextView attended;
        TextView time;
        TextView customer_name;
        TextView project_name;
        TextView wo_number;
        TableLayout tableList;
    }

    @Override
    public View getView(int position, View convertView, ViewGroup parent) {

        ViewHolder holder = null;

        LayoutInflater inflater = (LayoutInflater) mContext
                .getSystemService(Context.LAYOUT_INFLATER_SERVICE);
        if (convertView == null) {
            convertView = inflater.inflate(R.layout.item_view_attendance, null);
            holder = new ViewHolder();

            // get the textview's from the convertView
            holder.name = (TextView) convertView.findViewById(R.id.name);
            holder.date = (TextView) convertView.findViewById(R.id.date);
            holder.attended = (TextView) convertView.findViewById(R.id.attended);
            holder.time = (TextView) convertView.findViewById(R.id.time);
            holder.customer_name = (TextView) convertView.findViewById(R.id.customer_name);
            holder.project_name = (TextView) convertView.findViewById(R.id.project_name);
            holder.wo_number = (TextView) convertView.findViewById(R.id.wo_number);
            holder.tableList = (TableLayout) convertView.findViewById(R.id.tableLayout21);
            // store it in a Tag as its the first time this view is generated
            convertView.setTag(holder);
        } else {
            /* get the View from the existing Tag */
            holder = (ViewHolder) convertView.getTag();
        }

        /* update the textView's text and color of list item */
        holder.name.setText((CharSequence) itemList.get(position).get(Config.TAG_NAME));
        holder.date.setText((CharSequence) itemList.get(position).get(Config.TAG_DATE));
        holder.attended.setText((CharSequence) itemList.get(position).get(Config.TAG_ATTENDED));
        holder.time.setText((CharSequence) itemList.get(position).get(Config.TAG_TIME_INFORMATION));
        holder.customer_name.setText((CharSequence) itemList.get(position).get(Config.KEY_CUSTOMER_NAME));
        holder.project_name.setText((CharSequence) itemList.get(position).get(Config.KEY_PROJECT_NAME));
        holder.wo_number.setText((CharSequence) itemList.get(position).get(Config.KEY_WO_NUMBER));
        String status = ((String)itemList.get(position).get(Config.TAG_STATUS));
        if (status.equals("1")){
            holder.name.setBackgroundResource(R.drawable.bg_gray);
            holder.name.setTextColor(Color.parseColor("#FFFFFF"));
            holder.attended.setTextSize(16);
            holder.time.setTextSize(16);
            holder.customer_name.setTextSize(16);
            holder.project_name.setTextSize(16);
            holder.wo_number.setTextSize(16);
            LinearLayout.LayoutParams param = new LinearLayout.LayoutParams(LinearLayout.LayoutParams.WRAP_CONTENT, LinearLayout.LayoutParams.WRAP_CONTENT);
            param.setMargins(0,0,0,0);
            holder.date.setLayoutParams(param);

        }else if (status.equals("0")){
            holder.name.setBackgroundResource(R.drawable.bg_white);
            holder.name.setTextColor(Color.DKGRAY);
            holder.attended.setTextSize(0);
            holder.time.setTextSize(0);
            holder.customer_name.setTextSize(0);
            holder.project_name.setTextSize(0);
            holder.wo_number.setTextSize(0);
            LinearLayout.LayoutParams param = new LinearLayout.LayoutParams(LinearLayout.LayoutParams.WRAP_CONTENT, LinearLayout.LayoutParams.WRAP_CONTENT);
            param.setMargins(0,30,0,0);
            holder.date.setLayoutParams(param);
        }

        return convertView;
    }

}