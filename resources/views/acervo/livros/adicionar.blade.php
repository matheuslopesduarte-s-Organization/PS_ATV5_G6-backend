<?php 
    use App\Models\Autor;
    use App\Models\Editora;
    use App\Models\Genero;
    use App\Models\ClassificacaoIndicativa;

    $editoras = Editora::all();
    $autores = Autor::all();
    $generos = Genero::all();
    $classificacoes = ClassificacaoIndicativa::all();
?>

@extends('layouts.acervoLayout')

@section('style')
<style>
        .image-container {
            display: flex;
            flex-wrap: wrap;
        }
        .image-container .image-wrapper {
            position: relative;
            margin: 10px;
        }
        .image-container img {
            max-width: 200px;
            display: block;
        }
        .remove-btn {
            position: absolute;
            top: 5px;
            right: 5px;
            background: red;
            color: white;
            border: none;
            border-radius: 50%;
            padding: 5px;
            cursor: pointer;
        }
    </style>
@endsection


@section('acervoContent')
    <h1>Adicionar Livro</h1>

    <form id="form" action="{{ route('acervo.livros.store') }}" method="POST">
        @csrf
        <label for= "fileInput"></label>Imagens</label>
        <input type="file" id="fileInput" multiple accept="image/*">
        <div class="image-container" id="imageContainer"></div>
        <br>

        <label for="titulo">Título</label>
        <input type="text" name="titulo" id="titulo" required>
        <br>
        <label for="autor">Autor</label>
        <select name="autor" id="autor" required>
            @foreach($autores as $autor)
                <option value="{{ $autor->id }}">{{ $autor->nome }}</option>
            @endforeach
        </select>
        <button id="AdiconarAutor" type="button">Adicionar Autor</button>
        <br>
        <label for="editora">Editora</label>
        <select name="editora" id="editora" required>
            @foreach($editoras as $editora)
                <option value="{{ $editora->id }}">{{ $editora->nome }}</option>
            @endforeach
        </select>
        <button id="AdiconarEditora" type="button">Adicionar Editora</button>
        <br>
        <label for="genero">Genero</label>
        <select name="genero" id="genero" required>
            @foreach($generos as $genero)
                <option value="{{ $genero->id }}">{{ $genero->nome }}</option>
            @endforeach
        </select>
        <button id="AdiconarGenero" type="button">Adicionar Genero</button>
        <br>
        <label for="classificacao">Classificação Indicativa</label>
        <select name="classificacao" id="classificacao" required>
            @foreach($classificacoes as $classificacao)
                <option value="{{ $classificacao->id }}">{{ $classificacao->nome }}</option>
            @endforeach
        </select>
        <button id="AdiconarClassificacao" type="button">Adicionar Classificação</button>
        <br>
        <label for="ano">Ano</label>
        <input type="number" name="ano" id="ano" required>
        <br>
        <label for="isbn">ISBN</label>
        <input type="text" name="isbn" id="isbn" required>
        <br>
        <label for="descricao">Descrição</label>
        <textarea name="descricao" id="descricao" required></textarea>
        <br>
        <br>
        <input type="submit" value="Adicionar">
    </form>
@endsection
@section('script')
<script>
        const formulario =document.getElementById('form');
        const fileInput = document.getElementById('fileInput');
        const imageContainer = document.getElementById('imageContainer');
        const imagesArray = [];

        fileInput.addEventListener('change', (event) => {
            const files = event.target.files;

            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                const reader = new FileReader();

                reader.onload = (e) => {
                    const base64Image = e.target.result;
                    imagesArray.push(base64Image);

                    const imageWrapper = document.createElement('div');
                    imageWrapper.className = 'image-wrapper';

                    const img = document.createElement('img');
                    img.src = base64Image;

                    const removeBtn = document.createElement('button');
                    removeBtn.className = 'remove-btn';
                    removeBtn.textContent = 'X';
                    removeBtn.addEventListener('click', () => {
                        imageWrapper.remove();
                        const index = imagesArray.indexOf(base64Image);
                        if (index > -1) {
                            imagesArray.splice(index, 1);
                        }
                      
                    });

                    imageWrapper.appendChild(img);
                    imageWrapper.appendChild(removeBtn);
                    imageContainer.appendChild(imageWrapper);
                };

                reader.readAsDataURL(file);
            }
        });

        formulario.addEventListener('submit', (event) => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'imagens';
            input.value = JSON.stringify(imagesArray);
            formulario.appendChild(input);
        });

        
    </script>

@endsection