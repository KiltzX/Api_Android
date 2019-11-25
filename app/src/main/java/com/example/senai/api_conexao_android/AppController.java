package com.example.senai.api_conexao_android;

import android.app.Application;
import android.text.TextUtils;

import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.toolbox.Volley;

/**
 * Created by tecinfo on 27/03/2017.
 */

public class AppController extends Application {
    public static final String TAG =
            AppController.class.getSimpleName();
    private RequestQueue fila;
    private static AppController instancia;

    @Override
    public void onCreate(){
        super.onCreate();
        instancia = this;
    }
    public static synchronized AppController getInstancia(){
        return instancia;
    }
    public RequestQueue getFila(){
        if(fila == null){
            fila = Volley.newRequestQueue(
                    getApplicationContext());
        } return fila;
    }
    public <T> void adicionarParaFila(
            Request<T> req, String tag){
        req.setTag(TextUtils.isEmpty(tag)?TAG:tag);
        getFila().add(req);
    }
    public <T> void adicionarParaFila(Request<T> req){
        req.setTag(TAG);
        getFila().add(req);
    }
}
