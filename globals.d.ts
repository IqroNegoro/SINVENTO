import { route as routeFn } from 'ziggy-js';
declare global {
    interface Link {
        url: string,
        label: string,
        active: boolean
    }
    
    interface Category {
        id: number,
        code: string,
        name: string,
        created_at: Date,
        updated_at: Date,
    }

    interface Voucher {
        id: number,
        code: string,
        name: string,
        description: string,
        type: "fixed" | "percentage",
        value: number,
        valid_from: Date | number,
        valid_to: Date | number | null,
        stock: number | null,
        used: number,
        active: boolean,
        created_at: Date,
        updated_at: Date
    }

    interface Item {
        id: number,
        category_id: number | null,
        category: Category,
        name: string,
        image: string | null,
        stock: number,
        sell_price: number,
        buy_price: number
        created_at: Date,
        updated_at: Date,
    }

    interface Sale {
        id: number,
        voucher: Voucher,
        subtotal: number,
        total: number,
        created_at: Date,
        updated_at: Date,
    }

    interface DetailItem {
        id: number,
        item: Item,
        price: number,
        total: number,
        qty: number
        created_at: Date,
        updated_at: Date,
    }
}

declare module 'vue' {
    interface ComponentCustomProperties {
        route: typeof routeFn;
    }
}


export {}