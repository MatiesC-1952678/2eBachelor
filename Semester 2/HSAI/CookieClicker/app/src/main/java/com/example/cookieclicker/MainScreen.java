package com.example.cookieclicker;

import android.os.Bundle;
import android.view.View;
import android.widget.EditText;

import androidx.annotation.Nullable;
import androidx.appcompat.app.AppCompatActivity;

public class MainScreen extends AppCompatActivity {
    private Integer clickAmount = 0;
    @Override
    protected void onCreate(@Nullable Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.main_screen);
    }

    public void increaseNumber(View view) {
        EditText editText = findViewById(R.id.number);
        editText.setText((++clickAmount).toString());
    }
}
