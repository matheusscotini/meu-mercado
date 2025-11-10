# Teste - Cadastro de Pedidos de Supermercado

Este projeto implementa um sistema simples de cadastro de pedidos de supermercado, com:

- **Backend** em Laravel (PHP)
- **Frontend** em React + Vite
- Atualização de estoque em tempo real via API
- Validações de quantidade e alerta de estoque insuficiente

## Decisões tomadas

- **Separação clara** entre backend (`backend-laravel`) e frontend (`frontend-react`) para facilitar manutenção, testes e deploy independente.
- Backend exposto como **API REST** enxuta:
  - `GET /api/products` → produtos com preço e estoque
  - `GET /api/stock` → visão consolidada do estoque (nome + quantidade)
  - `POST /api/orders` → criação de pedidos, valida estoque e debita automaticamente
- Banco modelado de forma clássica:
  - `products` (id, name, price, qty_stock)
  - `orders` (id, customer_name, delivery_date, total_amount)
  - `order_items` (id, order_id, product_id, quantity, unit_price, subtotal)
- A lógica de negócio crítica (validação de estoque, débito e cálculo de total) é feita dentro de **transação** no Laravel para garantir consistência.
- Frontend focado em **layout limpo e organizado**, com:
  - formulário simples e direto,
  - tabela de itens,
  - total calculado em tempo real,
  - edição e remoção de itens já adicionados,
  - exibição do estoque atual.

## Como rodar o projeto

### Frontend (React)

```
cd frontend-react
npm install
npm run dev
```