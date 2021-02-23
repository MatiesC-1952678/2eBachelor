package com.example.iou;

import androidx.room.ColumnInfo;
import androidx.room.Entity;
import androidx.room.PrimaryKey;

@Entity
public class Friend {
    public Friend(String name, Float cost) {
        this.name = name;
        this.cost = cost;
    }

    @PrimaryKey
    private int uid;

    public int getUid() {
        return uid;
    }
    public void setUid(int uid) {
        this.uid = uid;
    }

    @ColumnInfo(name = "name")
    public String name;

    @ColumnInfo(name = "cost")
    public Float cost;

}
