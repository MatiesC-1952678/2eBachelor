package com.example.iou;

import androidx.room.Database;
import androidx.room.RoomDatabase;

@Database(entities = {Friend.class}, version = 1)
public abstract class friendDatabase extends RoomDatabase {
    public abstract FriendDao friendDao();
}
