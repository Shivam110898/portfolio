/*
* This activity is used to get the details of the movie that is selected by the user. Movie data
* such as the name, summary, cast, reviews, and trailers of the movie.
*
* */

package com.example.shiv.movieapp.activities;

//import the required packages
import android.content.Context;
import android.content.Intent;
import android.net.ConnectivityManager;
import android.net.NetworkInfo;
import android.net.Uri;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.support.v7.widget.Toolbar;
import android.text.TextUtils;
import android.view.View;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.RatingBar;
import android.widget.TextView;
import android.widget.Toast;
import com.bumptech.glide.Glide;
import com.bumptech.glide.request.RequestOptions;
import com.example.shiv.movieapp.ApiClient;
import com.example.shiv.movieapp.R;
import com.example.shiv.movieapp.interfaces.OnGetCastCallback;
import com.example.shiv.movieapp.interfaces.OnGetGenresCallback;
import com.example.shiv.movieapp.interfaces.OnGetMovieCallback;
import com.example.shiv.movieapp.interfaces.OnGetReviewsCallback;
import com.example.shiv.movieapp.interfaces.OnGetTrailersCallback;
import com.example.shiv.movieapp.models.Cast;
import com.example.shiv.movieapp.models.Genre;
import com.example.shiv.movieapp.models.Movie;
import com.example.shiv.movieapp.models.Review;
import com.example.shiv.movieapp.models.Trailer;
import java.util.ArrayList;
import java.util.List;

public class MovieActivity extends AppCompatActivity {

    //class variables
    public static String MOVIE_ID = "movie_id";
    private static String IMAGE_BASE_URL = "http://image.tmdb.org/t/p/w780";
    private static String YOUTUBE_VIDEO_URL = "http://www.youtube.com/watch?v=%s";
    private static String YOUTUBE_THUMBNAIL_URL = "http://img.youtube.com/vi/%s/0.jpg";
    private ImageView movieBackdrop;
    private TextView movieTitle;
    private TextView movieOverview;
    private TextView movieOverviewLabel;
    private TextView movieReleaseDate;
    private RatingBar movieRating;
    private TextView trailersLabel;
    private LinearLayout movieTrailers;
    private LinearLayout movieReviews;
    private TextView reviewsLabel;
    private TextView movieGenres;
    private ApiClient apiClient;
    private int movieId;
    private TextView castLabel;
    private LinearLayout movieCast;

    //initialise Movie activity
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        isNetworkAvailable();
        setContentView(R.layout.activity_movie);//set activity UI to layout activity_movie.xml
        movieId = getIntent().getIntExtra(MOVIE_ID, movieId);//get intent data that is passed from the MainActivity
        apiClient = ApiClient.getInstance();//create an instance of the API service
        Toolbar toolbar = findViewById(R.id.toolbar);//set toolbar
        setSupportActionBar(toolbar);

        if (getSupportActionBar() != null) {
            getSupportActionBar().setDisplayHomeAsUpEnabled(true);
            getSupportActionBar().setDisplayShowTitleEnabled(false);
        }

        //Find the UI widgets and set them to the API object variables
        movieBackdrop = findViewById(R.id.movieDetailsBackdrop);
        movieTitle = findViewById(R.id.movieDetailsTitle);
        movieOverview = findViewById(R.id.movieDetailsOverview);
        movieOverviewLabel = findViewById(R.id.summaryLabel);
        movieReleaseDate = findViewById(R.id.movieDetailsReleaseDate);
        movieRating = findViewById(R.id.movieDetailsRating);
        movieTrailers = findViewById(R.id.movieTrailers);
        movieReviews = findViewById(R.id.movieReviews);
        movieGenres = findViewById(R.id.movieDetailsGenres);
        trailersLabel = findViewById(R.id.trailersLabel);
        reviewsLabel = findViewById(R.id.reviewsLabel);
        movieCast = findViewById(R.id.movieCast);
        castLabel = findViewById(R.id.castLabel);
        getMovie();//call the getMovie method
    }

    //method to check network status
    private void isNetworkAvailable() {
        ConnectivityManager connectivityManager = (ConnectivityManager) getSystemService(Context.CONNECTIVITY_SERVICE);
        NetworkInfo activeNetworkInfo = connectivityManager.getActiveNetworkInfo();
        if (activeNetworkInfo == null){
            showError();
        } else {
            activeNetworkInfo.isConnected();
        }
    }

    //get details of the specific movie using the movieID
    private void getMovie() {
        //call getMovie method in the API service class
        apiClient.getMovie(movieId, new OnGetMovieCallback() {
            @Override
            public void onSuccess(Movie movie) {
                movieTitle.setText(movie.getTitle());
                movieOverviewLabel.setVisibility(View.VISIBLE);
                movieOverview.setText(movie.getOverview());
                movieRating.setVisibility(View.VISIBLE);
                movieRating.setRating((float) (movie.getRating() / 2));
                getGenres(movie);
                getCast(movie);
                getTrailers(movie);
                getReviews(movie);
                movieReleaseDate.setText(movie.getReleaseDate());
                if (!isFinishing()) {
                    Glide.with(MovieActivity.this)
                            .load(IMAGE_BASE_URL + movie.getBackdropPath())
                            .apply(RequestOptions.placeholderOf(R.color.colorPrimary))
                            .into(movieBackdrop);
                }
            }

            @Override
            public void onError() {
                finish();
            }
        });
    }

    //get cast of the movies using the movie id
    private void getCast(Movie movie) {
        apiClient.getCast(movie.getId(), new OnGetCastCallback() {
            @Override
            public void onSuccess(List<Cast> casts) {
                castLabel.setVisibility(View.VISIBLE);
                movieCast.removeAllViews();
                for (final Cast cast : casts) {
                    View parent = getLayoutInflater().inflate(R.layout.thumbnail_cast, movieCast, false);
                    ImageView thumbnail = parent.findViewById(R.id.castImg);
                    thumbnail.requestLayout();
                    Glide.with(MovieActivity.this)
                            .load(IMAGE_BASE_URL + cast.getProfile_path())
                            .apply(RequestOptions.placeholderOf(R.color.colorPrimary).centerCrop())
                            .into(thumbnail);
                    TextView castName = parent.findViewById(R.id.castName);
                    TextView character = parent.findViewById(R.id.characterName);
                    character.setText(String.format("In as %s", cast.getCharacter()));
                    castName.setText(cast.getName());
                    movieCast.addView(parent);
                }
            }

            @Override
            public void onError() {
                // Do nothing
                castLabel.setVisibility(View.GONE);
            }
        });
    }

    //get the reviews of the movie
    private void getReviews(Movie movie) {
        apiClient.getReviews(movie.getId(), new OnGetReviewsCallback() {
            @Override
            public void onSuccess(List<Review> reviews) {
                reviewsLabel.setVisibility(View.VISIBLE);
                movieReviews.removeAllViews();
                for (Review review : reviews) {
                    View parent = getLayoutInflater().inflate(R.layout.reviews, movieReviews, false);
                    TextView author = parent.findViewById(R.id.reviewAuthor);
                    TextView content = parent.findViewById(R.id.reviewContent);
                    author.setText(review.getAuthor());
                    content.setText(review.getContent());
                    movieReviews.addView(parent);
                }
            }

            @Override
            public void onError() {
                // Do nothing
            }
        });
    }

    //get the genres of the movie
    private void getGenres(final Movie movie) {
        apiClient.getGenres(new OnGetGenresCallback() {
            @Override
            public void onSuccess(List<Genre> genres) {
                if (movie.getGenres() != null) {
                    List<String> currentGenres = new ArrayList<>();
                    for (Genre genre : movie.getGenres()) {
                        currentGenres.add(genre.getName());
                    }
                    movieGenres.setText(TextUtils.join(", ", currentGenres));
                }
            }

            @Override
            public void onError() {
                showError();
            }
        });
    }

    //get the trailers
    private void getTrailers(Movie movie) {
        apiClient.getTrailers(movie.getId(), new OnGetTrailersCallback() {
            @Override
            public void onSuccess(List<Trailer> trailers) {
                trailersLabel.setVisibility(View.VISIBLE);
                movieTrailers.removeAllViews();
                for (final Trailer trailer : trailers) {
                    View parent = getLayoutInflater().inflate(R.layout.thumbnail_trailer, movieTrailers, false);
                    ImageView thumbnail = parent.findViewById(R.id.thumbnail);
                    thumbnail.requestLayout();
                    thumbnail.setOnClickListener(new View.OnClickListener() {
                        @Override
                        public void onClick(View v) {
                            showTrailer(String.format(YOUTUBE_VIDEO_URL, trailer.getKey()));
                        }
                    });
                    Glide.with(MovieActivity.this)
                            .load(String.format(YOUTUBE_THUMBNAIL_URL, trailer.getKey()))
                            .apply(RequestOptions.placeholderOf(R.color.colorPrimary).centerCrop())
                            .into(thumbnail);
                    movieTrailers.addView(parent);
                }
            }

            @Override
            public void onError() {
                // Do nothing
                trailersLabel.setVisibility(View.GONE);
            }
        });
    }

    private void showTrailer(String url) {
        Intent intent = new Intent(Intent.ACTION_VIEW, Uri.parse(url));
        startActivity(intent);
    }

    @Override
    public boolean onSupportNavigateUp() {
        onBackPressed();
        return true;
    }

    private void showError() {
        Toast.makeText(MovieActivity.this, "Please check your internet connection.", Toast.LENGTH_SHORT).show();
    }
}
