<!doctype html>
<html lang="pt-BR">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<title>TODO List • CI3.1</title>

	<!-- Bootstrap 5 -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

	<style>
		body { background:#f8f9fa; }
		.done { text-decoration:line-through; opacity:.6; }
		.todo-card { transition: box-shadow .2s; }
		.todo-card:hover { box-shadow:0 0 10px rgba(0,0,0,.08); }
	</style>
</head>
<body class="container py-5">

<h1 class="text-center mb-4">📝 TODO List</h1>

<!-- Form de criação -->
<div class="card shadow-sm mb-4">
	<div class="card-body">
		<form id="form" class="row g-3">
			<div class="col-md-4">
				<input id="title" class="form-control" placeholder="Título *" required />
			</div>
			<div class="col-md-5">
				<input id="desc" class="form-control" placeholder="Descrição (opcional)" />
			</div>
			<div class="col-md-3 d-grid">
				<button class="btn btn-primary" type="submit">Adicionar</button>
			</div>
		</form>
	</div>
</div>

<!-- Campo de busca -->
<div class="input-group mb-4">
	<span class="input-group-text">🔍</span>
	<input id="search" type="text" class="form-control" placeholder="Buscar por título ou descrição..." />
</div>

<!-- Lista -->
<div id="list" class="d-flex flex-column gap-3"></div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
	const API = '/api/todos';
	const list = document.getElementById('list');
	const searchInput = document.getElementById('search');
	let todos = [];

	async function fetchJSON(url, opts = {}) {
		const res = await fetch(url, { headers: { 'Content-Type': 'application/json' }, ...opts });
		return res.json();
	}

	async function load() {
		const { data } = await fetchJSON(API);
		todos = data;
		render(todos);
	}

	function render(items) {
		list.innerHTML = '';

		if (items.length === 0) {
			list.innerHTML = `
          <div class="alert alert-warning text-center" role="alert">
            Nenhuma tarefa encontrada.
          </div>`;
			return;
		}

		items.forEach(t => list.appendChild(renderItem(t)));
	}

	function renderItem(t) {
		const div = document.createElement('div');
		div.className = 'card todo-card';
		div.innerHTML = `
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center mb-2">
            <h5 class="card-title mb-0 ${t.status === 'done' ? 'done' : ''}">${t.title}</h5>
            <small class="text-muted">${new Date(t.created_at.replace(' ','T')).toLocaleString()}</small>
          </div>
          ${t.description ? `<p class="card-text mb-2">${t.description}</p>` : ''}
          <div class="d-flex justify-content-between">
            <div class="btn-group" role="group">
              <button class="btn btn-sm ${t.status === 'done' ? 'btn-warning' : 'btn-success'}"
                      data-action="toggle" data-id="${t.id}">
                ${t.status === 'done' ? 'Marcar pendente' : 'Marcar concluída'}
              </button>
              <button class="btn btn-sm btn-outline-secondary" data-action="edit" data-id="${t.id}">
                Editar
              </button>
            </div>
            <button class="btn btn-sm btn-outline-danger" data-action="delete" data-id="${t.id}">
              Excluir
            </button>
          </div>
        </div>`;
		return div;
	}

	// Criação
	document.getElementById('form').addEventListener('submit', async e => {
		e.preventDefault();
		const title = document.getElementById('title').value.trim();
		const description = document.getElementById('desc').value.trim();
		if (!title) return alert('Título é obrigatório');
		await fetchJSON(API, { method: 'POST', body: JSON.stringify({ title, description }) });
		e.target.reset();
		load();
	});

	// Ações: excluir, editar, alternar status
	list.addEventListener('click', async e => {
		const btn = e.target.closest('button');
		if (!btn) return;
		const id = btn.dataset.id, action = btn.dataset.action;

		if (action === 'delete') {
			if (confirm('Excluir esta tarefa?')) {
				await fetchJSON(`${API}/${id}`, { method:'DELETE' });
				load();
			}
			return;
		}

		if (action === 'toggle') {
			const { data } = await fetchJSON(`${API}/${id}`);
			const next = data.status === 'done' ? 'pending' : 'done';
			await fetchJSON(`${API}/${id}`, { method:'PUT', body: JSON.stringify({ status: next }) });
			load();
			return;
		}

		if (action === 'edit') {
			const { data } = await fetchJSON(`${API}/${id}`);
			const title = prompt('Novo título:', data.title);
			if (title === null) return;
			const description = prompt('Nova descrição:', data.description || '');
			await fetchJSON(`${API}/${id}`, { method:'PUT', body: JSON.stringify({ title, description }) });
			load();
			return;
		}
	});

	// Filtro de busca
	searchInput.addEventListener('input', e => {
		const term = e.target.value.toLowerCase();
		const filtered = todos.filter(t =>
			t.title.toLowerCase().includes(term) ||
			(t.description && t.description.toLowerCase().includes(term))
		);
		render(filtered);
	});

	load();
</script>
</body>
</html>
