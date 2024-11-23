package com.example.shiv.movieapp.interfaces;

import com.example.shiv.movieapp.models.Movie;

import java.util.List;

public interface OnGetMoviesCallback {
    void onSuccess(int page, List<Movie> movies);

    void onError();
}
