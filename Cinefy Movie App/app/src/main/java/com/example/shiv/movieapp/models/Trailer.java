package com.example.shiv.movieapp.models;

import com.google.gson.annotations.SerializedName;

public class Trailer {
    @SerializedName("key")
    private String key;

    public String getKey() {
        return key;
    }

    public void setKey(String key) {
        this.key = key;
    }
}
