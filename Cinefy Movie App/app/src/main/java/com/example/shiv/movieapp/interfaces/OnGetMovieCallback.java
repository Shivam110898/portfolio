package com.example.shiv.movieapp.interfaces;

import com.example.shiv.movieapp.models.Movie;

public interface OnGetMovieCallback {
    void onSuccess(Movie movie);

    void onError();
}
