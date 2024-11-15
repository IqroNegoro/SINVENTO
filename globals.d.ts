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

    interface Item {
        id: number,
        category_id: number,
        category: Category,
        user_id: number,
        name: string,
        image: string,
        stock: number,
        sell_price: number,
        buy_price: number
        created_at: Date,
        updated_at: Date,
    }

    interface Sale {
        id: number,
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

export {}