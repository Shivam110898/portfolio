package com.example.shiv.movieapp.interfaces;

import com.example.shiv.movieapp.models.Cast;

import java.util.List;

public interface OnGetCastCallback {
    void onSuccess(List<Cast> casts);

    void onError();
}
