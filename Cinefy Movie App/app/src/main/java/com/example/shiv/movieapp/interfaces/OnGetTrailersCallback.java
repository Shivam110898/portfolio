package com.example.shiv.movieapp.interfaces;

import com.example.shiv.movieapp.models.Trailer;

import java.util.List;

public interface OnGetTrailersCallback {
    void onSuccess(List<Trailer> trailers);

    void onError();
}
