package com.example.iou;

import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.ImageButton;
import android.widget.TextView;


public class CustomDataAdapter extends BaseAdapter {
    private FriendDao dao;
    private final LayoutInflater inflater;
    private deleteButtonInterface listener;

    public CustomDataAdapter(Context applicationContext, FriendDao dao) {
        this.dao = dao;
        inflater = (LayoutInflater.from(applicationContext));
    }

    public void setListener(deleteButtonInterface listener) {
        this.listener = listener;
    }

    @Override
    public int getCount() {
        return dao.getAll().size();
    }

    @Override
    public Object getItem(int i) {
        return null;
    }

    @Override
    public long getItemId(int i) {
        return 0;
    }

    @Override
    public View getView(int i, View view, ViewGroup viewGroup) {
        Friend f = dao.getAll().get(i);

        if (view == null) {
            view = initView(i, viewGroup);
        }

        TextView person = view.findViewById(R.id.name);
        person.setText(f.name);
        TextView cost = view.findViewById(R.id.cost);
        cost.setText(String.format("€%s", f.cost.toString()));

        return view;
    }

    /**
     * when the view is not yet initialized, the layout inflater will produce all the components for a
     * smoother scrolling experience (meaning the same sizes of components will be produced)
     * AND
     * the button listener will be initialized
     * @param i
     * @param viewGroup
     * @return
     */
    private View initView(int i, ViewGroup viewGroup) {
        View view = inflater.inflate(R.layout.activity_listviewitem, viewGroup, false);
        ImageButton button = view.findViewById(R.id.delete);
        button.setOnClickListener(v -> {
            if (listener != null)
            {
                listener.deleteButtonMethod(i);
            }
        });
        return view;
    }
}

