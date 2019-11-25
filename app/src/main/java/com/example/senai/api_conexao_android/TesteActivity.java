package com.example.senai.api_conexao_android;

import androidx.appcompat.app.AppCompatActivity;

import android.os.Bundle;
import android.view.View;
import android.widget.EditText;
import android.widget.ProgressBar;
import android.widget.TextView;

import com.android.volley.VolleyError;

import java.util.HashMap;

/**
 * Classe do tipo VIEW - apenas realizar funcionaciolidades relacionadas à interface gráfica e UX
 */
public class TesteActivity extends AppCompatActivity
        implements IDadosEventListener{

    private TesteController testeController;

    private EditText etTeste;
    private TextView tvTeste;
    private ProgressBar pbTeste;


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_teste);
        this.testeController = new TesteController(this);
        this.etTeste = findViewById(R.id.etTeste);
        this.tvTeste = findViewById(R.id.tvTexto);
        this.pbTeste = findViewById(R.id.pbTeste);
    }

    public void enviar(View view) {
        String s = etTeste.getText().toString();
        this.pbTeste.setVisibility(ProgressBar.VISIBLE);
        this.testeController.enviarParaPHP(s);
    }

    @Override
    public void eventoRetornouOk(Object response) {
        this.pbTeste.setVisibility(ProgressBar.GONE);
        this.tvTeste.setText(String.valueOf(response));
    }

    @Override
    public void eventoRetornouErro(VolleyError error) {
        this.pbTeste.setVisibility(ProgressBar.GONE);
        this.tvTeste.setText(error.toString());
    }
}
