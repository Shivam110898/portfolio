package com.example.shiv.movieapp.interfaces;

import com.example.shiv.movieapp.models.Genre;

import java.util.List;

public interface OnGetGenresCallback {

    void onSuccess(List<Genre> genres);

    void onError();
}
