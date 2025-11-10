const API_BASE_URL = "http://127.0.0.1:8000/api";

export async function fetchProducts() {
  const res = await fetch(`${API_BASE_URL}/products`);
  if (!res.ok) throw new Error("Erro ao carregar produtos");
  return res.json();
}

export async function fetchStock() {
  const res = await fetch(`${API_BASE_URL}/stock`);
  if (!res.ok) throw new Error("Erro ao carregar estoque");
  return res.json();
}

export async function createOrder(payload: {
  customer_name: string;
  delivery_date: string;
  items: { product_id: number; quantity: number }[];
}) {
  const res = await fetch(`${API_BASE_URL}/orders`, {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify(payload),
  });

  const data = await res.json();
  if (!res.ok) throw data;
  return data;
}
