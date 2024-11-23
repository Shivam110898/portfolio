package com.example.shiv.movieapp.activities;
//import the required packages
import android.content.Context;
import android.content.Intent;
import android.net.ConnectivityManager;
import android.net.NetworkInfo;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.PopupMenu;
import android.support.v7.widget.RecyclerView;
import android.support.v7.widget.Toolbar;
import android.view.Menu;
import android.view.MenuItem;
import android.widget.Toast;
import com.example.shiv.movieapp.ApiClient;
import com.example.shiv.movieapp.MoviesAdapter;
import com.example.shiv.movieapp.R;
import com.example.shiv.movieapp.interfaces.OnGetGenresCallback;
import com.example.shiv.movieapp.interfaces.OnGetMoviesCallback;
import com.example.shiv.movieapp.interfaces.OnMoviesClickCallback;
import com.example.shiv.movieapp.models.Genre;
import com.example.shiv.movieapp.models.Movie;
import java.util.List;


public class MainActivity extends AppCompatActivity {

    //class variables initialised
    private RecyclerView moviesList;
    private MoviesAdapter adapter;
    ApiClient apiClient = ApiClient.getInstance();
    private String sortBy = ApiClient.POPULAR;
    private boolean isFetchingMovies;
    private int currentPage = 1;
    private List<Genre> movieGenres;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);
        isNetworkAvailable();//check network status


    }

    //open MovieActivity when a user clicks on a movie item
    OnMoviesClickCallback callback = new OnMoviesClickCallback() {
        @Override
        public void onClick(Movie movie) {
            Intent intent = new Intent(MainActivity.this, MovieActivity.class);
            intent.putExtra(MovieActivity.MOVIE_ID, movie.getId());
            startActivity(intent);
        }
    };

    //function to check the network status
    private void isNetworkAvailable() {
        ConnectivityManager connectivityManager = (ConnectivityManager) getSystemService(Context.CONNECTIVITY_SERVICE);
        NetworkInfo activeNetworkInfo = connectivityManager.getActiveNetworkInfo();
        if (activeNetworkInfo == null){
            showError();
        } else {
            activeNetworkInfo.isConnected();
            Toolbar toolbar = findViewById(R.id.toolbar);
            setSupportActionBar(toolbar);
            moviesList = findViewById(R.id.movies_recycler_view);
            pagination();
            getGenres();
        }
    }

    //function to allow pagination - full movies list
    private void pagination() {
        final LinearLayoutManager manager = new LinearLayoutManager(this,LinearLayoutManager.HORIZONTAL,false);
        moviesList.setLayoutManager(manager);
        moviesList.addOnScrollListener(new RecyclerView.OnScrollListener() {
            @Override
            public void onScrolled(RecyclerView recyclerView, int dx, int dy) {
                int totalItemCount = manager.getItemCount();
                int visibleItemCount = manager.getChildCount();
                int firstVisibleItem = manager.findFirstVisibleItemPosition();

                if (firstVisibleItem + visibleItemCount >= totalItemCount / 2) {
                    if (!isFetchingMovies) {
                        getMovies(currentPage + 1);
                    }
                }
            }
        });
    }

    //function to get the genres of the movies
    private void getGenres() {
        apiClient.getGenres(new OnGetGenresCallback() {
            @Override
            public void onSuccess(List<Genre> genres) {
                movieGenres = genres;
                getMovies(currentPage);
            }

            @Override
            public void onError() {
                showError();
            }
        });
    }

    //function to fetch the movie data and bind it to the UI
    public void getMovies(int page){
        isFetchingMovies = true;
        apiClient.getMovies(page, "POPULAR", new OnGetMoviesCallback() {
            @Override
            public void onSuccess(int page, List<Movie> movies) {
                if (adapter == null) {
                    adapter = new MoviesAdapter(movies, movieGenres, callback);
                    moviesList.setAdapter(adapter);
                } else {
                    if (page == 1) {
                        adapter.clearMovies();
                    }
                    adapter.appendMovies(movies);
                }
                currentPage = page;
                isFetchingMovies = false;

                setTitle();
            }
            @Override
            public void onError() {
                showError();
            }
        });

    }

    //set the title of the toolbar when an option is selected
    private void setTitle() {
        switch (sortBy) {
            case ApiClient.POPULAR:
                setTitle(getString(R.string.popular));
                break;
            case ApiClient.TOP_RATED:
                setTitle(getString(R.string.top_rated));
                break;
            case ApiClient.UPCOMING:
                setTitle(getString(R.string.upcoming));
                break;
            case ApiClient.NOW_PLAYING:
                setTitle(getString(R.string.now_playing));
                break;
        }

    }

    //inflate the menu
    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        getMenuInflater().inflate(R.menu.menu_movies, menu);
        return super.onCreateOptionsMenu(menu);
    }

    //when the sorting menu button is clicked
    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        switch (item.getItemId()) {
            case R.id.sort:
                showSortMenu();
                return true;
            default:
                return super.onOptionsItemSelected(item);
        }
    }

    //display the menu items
    private void showSortMenu() {
        PopupMenu sortMenu = new PopupMenu(this, findViewById(R.id.sort));
        sortMenu.setOnMenuItemClickListener(new PopupMenu.OnMenuItemClickListener() {
            @Override
            public boolean onMenuItemClick(MenuItem item) {

                currentPage = 1;

                switch (item.getItemId()) {
                    case R.id.popular:
                        sortBy = ApiClient.POPULAR;
                        getMovies(currentPage);
                        return true;
                    case R.id.top_rated:
                        sortBy = ApiClient.TOP_RATED;
                        getMovies(currentPage);
                        return true;
                    case R.id.upcoming:
                        sortBy = ApiClient.UPCOMING;
                        getMovies(currentPage);
                        return true;
                    case R.id.now_playing:
                        sortBy = ApiClient.NOW_PLAYING;
                        getMovies(currentPage);
                        return true;
                    default:
                        return false;
                }
            }
        });
        sortMenu.inflate(R.menu.menu_movies_sort);
        sortMenu.show();
    }

    //message to show on the screen when error occurs
    private void showError() {
        Toast.makeText(MainActivity.this, "Please check your internet connection.", Toast.LENGTH_SHORT).show();
    }

}
