package com.fujitsu.fidworkingreport;

import android.content.Context;
import android.graphics.Color;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.SimpleAdapter;
import android.widget.TextView;

import java.util.List;
import java.util.Map;

/**
 * Created by Ryan Baskara on 29/07/2016.
 */
public class CustomSimpleAdapter extends SimpleAdapter {

    private List<Map<String, Object>> itemList;
    private Context mContext;

    public CustomSimpleAdapter(Context context, List<? extends Map<String, ?>> data,
                               int resource, String[] from, int[] to) {
        super(context, data, resource, from, to);

        this.itemList = (List<Map<String, Object>>) data;
        this.mContext = context;
    }

    /* A Static class for holding the elements of each List View Item
     * This is created as per Google UI Guideline for faster performance */
    class ViewHolder {
        TextView day;
        TextView date;
        TextView time_in_out;
        TextView time_information;
    }

    @Override
    public View getView(int position, View convertView, ViewGroup parent) {

        ViewHolder holder = null;

        LayoutInflater inflater = (LayoutInflater) mContext
                .getSystemService(Context.LAYOUT_INFLATER_SERVICE);
        if (convertView == null) {
            convertView = inflater.inflate(R.layout.item_list, null);
            holder = new ViewHolder();

            // get the textview's from the convertView
            holder.day = (TextView) convertView.findViewById(R.id.day);
            holder.date = (TextView) convertView.findViewById(R.id.date);
            holder.time_in_out = (TextView) convertView.findViewById(R.id.time_in_out);
            holder.time_information = (TextView) convertView.findViewById(R.id.time_information);
            // store it in a Tag as its the first time this view is generated
            convertView.setTag(holder);
        } else {
            /* get the View from the existing Tag */
            holder = (ViewHolder) convertView.getTag();
        }

        /* update the textView's text and color of list item */
        holder.day.setText((CharSequence) itemList.get(position).get(Config.TAG_DAY_NAME));
        holder.date.setText((CharSequence) itemList.get(position).get(Config.TAG_DATE));
        holder.time_information.setText((CharSequence) itemList.get(position).get(Config.TAG_TIME_INFORMATION));
        holder.time_in_out.setText((CharSequence) itemList.get(position).get(Config.TAG_TIME_IN_OUT));
        String status = ((String)itemList.get(position).get(Config.TAG_STATUS));
        if (status.equals("1")){
            holder.day.setBackgroundResource(R.drawable.bg_gray);
            holder.day.setTextColor(Color.parseColor("#FFFFFF"));
            holder.time_in_out.setTextSize(16);
            holder.time_information.setTextSize(16);
        }else if (status.equals("2")){
            holder.day.setBackgroundResource(R.drawable.bg_red);
            holder.day.setTextColor(Color.parseColor("#FFFFFF"));
            holder.time_in_out.setTextSize(0);
            holder.time_information.setTextSize(0);
        }else if (status.equals("0")){
            holder.day.setBackgroundResource(R.drawable.bg_white);
            holder.day.setTextColor(Color.DKGRAY);
            holder.time_in_out.setTextSize(0);
            holder.time_information.setTextSize(0);
        }


        return convertView;
    }

}