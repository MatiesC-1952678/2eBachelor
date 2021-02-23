package com.example.iou;

import androidx.room.Dao;
import androidx.room.Delete;
import androidx.room.Insert;
import androidx.room.Query;

import java.util.List;

@Dao
public interface FriendDao {
    @Query("SELECT * FROM Friend")
    List<Friend> getAll();

    @Query("SELECT * FROM Friend WHERE name LIKE :name LIMIT 1")
    Friend findByName(String name);

    @Query("INSERT INTO Friend (name, cost) VALUES (:name, :cost)")
    void insert(String name, Float cost);

    @Insert
    void insertAll(Friend... users);

    @Delete
    void delete(Friend user);
}
