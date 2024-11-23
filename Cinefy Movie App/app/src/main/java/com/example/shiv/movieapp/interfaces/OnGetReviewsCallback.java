package com.example.shiv.movieapp.interfaces;

import com.example.shiv.movieapp.models.Review;

import java.util.List;

public interface OnGetReviewsCallback {
    void onSuccess(List<Review> reviews);

    void onError();
}
