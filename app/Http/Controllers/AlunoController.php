<?php

namespace App\Http\Controllers;

use App\Models\Aluno;
use Illuminate\Http\Request;

class AlunoController extends Controller
{
    public function index()
    {
        $alunos = Aluno::all();
        return view('alunos.index', compact('alunos'));
    }

    public function create()
    {
        return view('alunos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome'            => 'required|min:3',
            'email'           => 'required|email|unique:alunos,email',
            'data_nascimento' => 'required|date',
        ]);

        Aluno::create($request->only(['nome', 'email', 'data_nascimento']));

        return redirect()->route('alunos.index')
                         ->with('sucesso', 'Aluno cadastrado com sucesso!');
    }

    public function edit(Aluno $aluno)
    {
        return view('alunos.edit', compact('aluno'));
    }

    public function update(Request $request, Aluno $aluno)
    {
        $request->validate([
            'nome'            => 'required|min:3',
            'email'           => 'required|email|unique:alunos,email,' . $aluno->id,
            'data_nascimento' => 'required|date',
        ]);

        $aluno->update($request->only(['nome', 'email', 'data_nascimento']));

        return redirect()->route('alunos.index')
                         ->with('sucesso', 'Aluno atualizado com sucesso!');
    }

    public function destroy(Aluno $aluno)
    {
        $aluno->delete();

        return redirect()->route('alunos.index')
                         ->with('sucesso', 'Aluno excluído com sucesso!');
    }
}