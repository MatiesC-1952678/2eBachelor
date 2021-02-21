package com.company;

import java.util.ArrayList;

public class Monitor {
    private long startTime;
    private long endTime;
    private final ArrayList<Long> times = new ArrayList<>();

    public void start() {
        startTime = System.currentTimeMillis();
    }

    public void end() {
        endTime = System.currentTimeMillis();
        long time = (endTime - startTime);
        times.add(time);
        //System.out.println("That took " + time + " milliseconds");
    }

    public void average() {
        long total = 0;
        for (long time: times) {
            total += time;
        }
        System.out.println("average: " + (total / 100.0f) + " miliseconds");
    }
}
