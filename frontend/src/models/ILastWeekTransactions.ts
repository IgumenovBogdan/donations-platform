interface Transactions {
    payed_at: string,
    sent: string
}

export interface ILastWeekTransactions {
    user: string,
    transactions: Transactions[]
}