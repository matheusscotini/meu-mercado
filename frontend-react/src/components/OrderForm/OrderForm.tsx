import { useEffect, useMemo, useState } from 'react';
import {
  fetchProducts,
  fetchStock,
  createOrder,
} from '../../services/api';
import styles from './OrderForm.module.css';

type Product = {
  id: number;
  name: string;
  price: number;
  qty_stock: number;
};

type StockItem = {
  name: string;
  qty_stock: number;
};

type OrderItem = {
  product_id: number;
  quantity: number | '';
};

export function OrderForm() {
  const [products, setProducts] = useState<Product[]>([]);
  const [stock, setStock] = useState<StockItem[]>([]);
  const [customerName, setCustomerName] = useState('');
  const [deliveryDate, setDeliveryDate] = useState('');
  const [items, setItems] = useState<OrderItem[]>([]);
  const [selectedProductId, setSelectedProductId] = useState<number | ''>('');
  const [selectedQty, setSelectedQty] = useState<number | ''>(1);
  const [errorMsg, setErrorMsg] = useState<string | null>(null);
  const [successMsg, setSuccessMsg] = useState<string | null>(null);
  const [loading, setLoading] = useState(false);

  useEffect(() => {
    Promise.all([fetchProducts(), fetchStock()])
      .then(([prodData, stockData]) => {
        setProducts(prodData);
        setStock(stockData);
      })
      .catch(() => {
        setErrorMsg('Erro ao carregar produtos/estoque.');
      });
  }, []);

  const detailedItems = useMemo(() => {
    return items.map((item) => {
      const product = products.find((p) => p.id === item.product_id);
      const unitPrice = product?.price ?? 0;
      const numericQty =
        typeof item.quantity === 'number' ? item.quantity : 0;

      const subtotal = unitPrice * numericQty;
      const stock = product?.qty_stock ?? 0;

      return {
        ...item,
        quantity: item.quantity,
        name: product?.name ?? '',
        unitPrice,
        subtotal,
        stock,
      };
    });
  }, [items, products]);

  const total = useMemo(
    () => detailedItems.reduce((sum, item) => sum + item.subtotal, 0),
    [detailedItems]
  );

  function handleAddItem() {
    setErrorMsg(null);

    if (!selectedProductId) return;

    const qty =
      typeof selectedQty === 'number' ? selectedQty : Number(selectedQty || 0);

    if (!qty || qty <= 0) {
      setErrorMsg('Informe uma quantidade válida para adicionar o item.');
      return;
    }

    const existingIndex = items.findIndex(
      (i) => i.product_id === selectedProductId
    );

    if (existingIndex >= 0) {
      const updated = [...items];
      const prevQty =
        typeof updated[existingIndex].quantity === 'number'
          ? updated[existingIndex].quantity
          : 0;
      updated[existingIndex].quantity = prevQty + qty;
      setItems(updated);
    } else {
      setItems([
        ...items,
        { product_id: selectedProductId as number, quantity: qty },
      ]);
    }

    setSelectedProductId('');
    setSelectedQty(1);
  }

  // aceita '' como estado intermediário para o input
  function handleChangeQty(product_id: number, quantity: number | '') {
    setErrorMsg(null);

    setItems((prev) =>
      prev.map((i) =>
        i.product_id === product_id ? { ...i, quantity } : i
      )
    );
  }

  function handleRemove(product_id: number) {
    setItems((prev) => prev.filter((i) => i.product_id !== product_id));
  }

  async function handleSubmit(e: React.FormEvent) {
    e.preventDefault();
    setErrorMsg(null);
    setSuccessMsg(null);

    if (!customerName || !deliveryDate || items.length === 0) {
      setErrorMsg(
        'Preencha Nome, Data de Entrega e adicione pelo menos um item.'
      );
      return;
    }

    // valida se todas as quantidades são válidas antes de enviar
    const hasInvalidQty = items.some(
      (i) =>
        !i.quantity ||
        typeof i.quantity !== 'number' ||
        i.quantity <= 0
    );

    if (hasInvalidQty) {
      setErrorMsg(
        'Defina uma quantidade válida (>= 1) para todos os itens antes de salvar.'
      );
      return;
    }

    setLoading(true);
    try {
      const payload = {
        customer_name: customerName,
        delivery_date: deliveryDate,
        items: items.map((i) => ({
          product_id: i.product_id,
          quantity: i.quantity as number,
        })),
      };

      const res = await createOrder(payload);

      setSuccessMsg(
        `Pedido #${res.order_id} criado com sucesso. Total R$ ${res.total_amount.toFixed(
          2
        )}`
      );
      setItems([]);
      setCustomerName('');
      setDeliveryDate('');

      const [prodData, stockData] = await Promise.all([
        fetchProducts(),
        fetchStock(),
      ]);
      setProducts(prodData);
      setStock(stockData);
    } catch (err: any) {
      if (err?.errors) {
        const allErrors = Object.values(err.errors)
          .flat()
          .join(' ');
        setErrorMsg(
          allErrors ||
            'Erro ao salvar pedido (dados inválidos ou estoque insuficiente).'
        );
      } else if (typeof err === 'string') {
        setErrorMsg(err);
      } else if (err?.message) {
        setErrorMsg(err.message);
      } else {
        setErrorMsg('Erro inesperado ao salvar pedido.');
      }
    } finally {
      setLoading(false);
    }
  }

  return (
    <form className={styles.container} onSubmit={handleSubmit}>
      <h1 className={styles.title}>Cadastro de Pedido de Supermercado</h1>
      <p className={styles.subtitle}>
        Informe os dados do cliente, selecione os produtos e acompanhe o total em tempo real.
      </p>

      <div className={styles.formRow}>
        <div className={styles.field}>
          <label className={styles.label}>Nome do Cliente</label>
          <input
            className={styles.input}
            value={customerName}
            onChange={(e) => setCustomerName(e.target.value)}
            placeholder="Ex: João da Silva"
          />
        </div>
        <div className={styles.field}>
          <label className={styles.label}>Data de Entrega</label>
          <input
            type="date"
            className={styles.input}
            value={deliveryDate}
            onChange={(e) => setDeliveryDate(e.target.value)}
          />
        </div>
      </div>

      {/* Lista de compras */}
      <table className={styles.itemsTable}>
        <thead>
          <tr>
            <th>Produto</th>
            <th>Estoque</th>
            <th>Qtd</th>
            <th>Preço un.</th>
            <th>Subtotal</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          {detailedItems.length === 0 && (
            <tr>
              <td colSpan={6}>Nenhum item adicionado.</td>
            </tr>
          )}

          {detailedItems.map((item) => (
            <tr key={item.product_id}>
              <td>{item.name}</td>
              <td>{item.stock}</td>
              <td>
                <input
                  type="number"
                  min={1}
                  className={styles.qtyInput}
                  value={
                    item.quantity === '' || item.quantity === 0
                      ? ''
                      : item.quantity
                  }
                  onChange={(e) => {
                    const value = e.target.value;
                    handleChangeQty(
                      item.product_id,
                      value === '' ? '' : Number(value)
                    );
                  }}
                  onFocus={(e) => e.target.select()}
                />
              </td>
              <td>R$ {item.unitPrice.toFixed(2)}</td>
              <td>R$ {item.subtotal.toFixed(2)}</td>
              <td>
                <button
                  type="button"
                  className={styles.removeBtn}
                  onClick={() => handleRemove(item.product_id)}
                >
                  remover
                </button>
              </td>
            </tr>
          ))}
        </tbody>
      </table>

      {/* Adicionar item */}
      <div className={styles.addItemRow}>
        <select
          className={styles.select}
          value={selectedProductId}
          onChange={(e) =>
            setSelectedProductId(
              e.target.value ? Number(e.target.value) : ''
            )
          }
        >
          <option value="">Selecione um produto</option>
          {products.map((p) => (
            <option key={p.id} value={p.id}>
              {p.name} — R$ {p.price.toFixed(2)} (Estoque: {p.qty_stock})
            </option>
          ))}
        </select>

        <input
          type="number"
          min={1}
          className={styles.qtyInput}
          value={
            selectedQty === '' || selectedQty === 0 ? '' : selectedQty
          }
          onChange={(e) => {
            const value = e.target.value;
            setSelectedQty(
              value === '' ? '' : Math.max(1, Number(value))
            );
          }}
          onFocus={(e) => e.target.select()}
        />

        <button
          type="button"
          className={styles.addBtn}
          onClick={handleAddItem}
        >
          + Adicionar item
        </button>
      </div>

      {/* Total */}
      <div className={styles.totalRow}>
        <span className={styles.totalLabel}>Total do pedido:</span>
        <span className={styles.totalValue}>
          R$ {total.toFixed(2)}
        </span>
      </div>

      {/* Alerts */}
      {errorMsg && <div className={styles.alert}>{errorMsg}</div>}
      {successMsg && <div className={styles.success}>{successMsg}</div>}

      <button
        type="submit"
        className={styles.submitBtn}
        disabled={loading}
      >
        {loading ? 'Salvando...' : 'Salvar Pedido'}
      </button>

      {/* Estoque atual */}
      <div className={styles.stockBox}>
        <div className={styles.stockTitle}>Estoque atual</div>
        <div className={styles.stockList}>
          {stock.map((s, i) => (
            <div key={i} className={styles.stockItem}>
              <span className={styles.stockProduct}>{s.name}</span>
              <span className={styles.stockQty}>{s.qty_stock} un.</span>
            </div>
          ))}
        </div>
      </div>
    </form>
  );
}
