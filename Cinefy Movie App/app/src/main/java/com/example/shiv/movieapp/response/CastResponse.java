package com.example.shiv.movieapp.response;

import com.example.shiv.movieapp.models.Cast;
import com.google.gson.annotations.SerializedName;

import java.util.List;

public class CastResponse {
    @SerializedName("cast")
    private List<Cast> castList;

    public List<Cast> getCastList() {
        return castList;
    }

    public void setCastList(List<Cast> castList) {
        this.castList = castList;
    }
}
