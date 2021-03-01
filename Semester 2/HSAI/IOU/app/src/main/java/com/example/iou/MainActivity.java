package com.example.iou;

import androidx.appcompat.app.AppCompatActivity;
import androidx.room.Room;

import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ListView;
import android.widget.TextView;

import java.util.List;

public class MainActivity extends AppCompatActivity implements deleteButtonInterface {
    public final static String PERSON_NAME = "person_name";
    public final static String PERSON_COST = "person_cost";
    public final static String PERSON_ID = "person_id";
    //private final ArrayList<String> persons = new ArrayList<>(Arrays.asList("jane", "margret", "john"));
    //private final ArrayList<Float> costs =  new ArrayList<>(Arrays.asList(40.20f, 20.30f, 77.50f));
    private FriendDao dao;
    private CustomDataAdapter adapter;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        initDatabase();
        initListView();
        insertAdded();
        doEdit();
        calculateTotal();
    }

    private void initDatabase() {
        friendDatabase db = Room.databaseBuilder(getApplicationContext(), friendDatabase.class, "database-name").allowMainThreadQueries().build();
        dao = db.friendDao();

        Friend Lisa = dao.findByName("Lisa");
        Friend Jan = dao.findByName("Jan");
        Friend Els = dao.findByName("Els");

        if (!(Lisa != null && Jan != null && Els != null)) {
            dao.insert("Lisa", 5.6f);
            dao.insert("Jan", 55.36f);
            dao.insert("Els", 15.20f);
        }
    }

    /**
     * Initialize the listview & adapter
     */
    private void initListView() {
        ListView list = findViewById(R.id.listView);
        adapter = new CustomDataAdapter(this, dao);
        adapter.setListener(this);
        list.setAdapter(adapter);

        // The itemclicklistener that is called when an item is pressed from the listview
        AdapterView.OnItemClickListener messageClickedHandler = (parent, v, i, id) -> {
            Intent intent = new Intent(MainActivity.this, ShowItem.class);
            Friend f = dao.getAll().get(i);
            intent.putExtra(PERSON_ID, Integer.toString(f.getUid()));
            intent.putExtra(PERSON_NAME, f.name);
            intent.putExtra(PERSON_COST, f.cost);
            startActivity(intent);
        };

        list.setOnItemClickListener(messageClickedHandler);
    }

    /**
     * The button click listener from the delete button interface that will be called when
     * a delete button from an item is pressed in the listview (see function above)
     */
    @Override
    public void deleteButtonMethod(int i) {
        dao.delete(dao.getAll().get(i));
        calculateTotal();
        adapter.notifyDataSetChanged();
    }

    /**
     * inserts the last item possibly sent by an intent that is added
     */
    private void insertAdded() {
        Intent intent = getIntent();
        String name_last_added = intent.getStringExtra(AddItem.ADD_PERSON_NAME);
        Float cost_last_added = intent.getFloatExtra(AddItem.ADD_PERSON_COST, 0.0f);
        if (name_last_added != null) {
            dao.insert(name_last_added, cost_last_added);
        }
    }

    private void doEdit() {
        Intent intent = getIntent();
        String id = intent.getStringExtra(ShowItem.EDIT_PERSON_ID);
        String name_edited = intent.getStringExtra(ShowItem.EDIT_PERSON_NAME);
        Float cost_edited = intent.getFloatExtra(ShowItem.EDIT_PERSON_COST, 0.0f);
        if (id != null) {
            dao.delete(dao.findById(id));
            dao.insert(name_edited, cost_edited);
        }
    }

    /**
     * calculates the total amount cost from the items in listview
     */
    private void calculateTotal() {
        Float total = 0f;
        List<Friend> list = dao.getAll();
        for (Friend f : list) {
            total += f.cost;
        }
        final String pre = "Totale Schuld: €";
        TextView totalText = findViewById(R.id.total);
        totalText.setText(String.format("%s%.2f", pre, total));
    }

    /**
     * the function that is called when the fab is pressed
     * this will result in opening the addItem activity
     * @param view
     */
    public void goToAddItemActivity(View view) {
        Intent intent = new Intent(MainActivity.this, AddItem.class);
        startActivity(intent);
    }

}