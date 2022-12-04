import {ILastWeekSum} from "../models/ILastWeekSum";
import {makeAutoObservable} from "mobx";
import StatisticsService from "../services/StatisticsService";
import {ILastWeekTransactions} from "../models/ILastWeekTransactions";
import LotService from "../services/LotService";
import {ILot} from "../models/ILot";


export default class OrganizationAccount {

    lots!: ILot[];
    lastWeekSum!: ILastWeekSum[];
    lastWeekTransactions!: ILastWeekTransactions[];
    isLoading = false;
    error = '';

    constructor() {
        makeAutoObservable(this)
    }

    setLots(lots: ILot[]) {
        this.lots = lots
    }

    setError(error: string) {
        this.error = error;
    }

    setLastWeekSum(lastWeekSum: ILastWeekSum[]) {
        this.lastWeekSum = lastWeekSum
    }

    setLastWeekTransactions(lastWeekTransactions: ILastWeekTransactions[]) {
        this.lastWeekTransactions = lastWeekTransactions
    }

    setLoading(bool: boolean) {
        this.isLoading = bool;
    }

    async getLotsByOrganization(take: number, sortBy?: string, s?: string) {
        this.setLoading(true)
        try {
            const response = await LotService.getLotsByOrganization(take, sortBy, s);
            this.setLots(response.data.data);
        } catch (e: any) {
            this.setError(e.response?.data?.message)
        } finally {
            this.setLoading(false)
        }
    }

    async createLot(data: {
        name: string,
        description: string,
        price: string
    }) {
        this.setLoading(true)
        try {
            const response = await LotService.create(data);
            const newLots = [...this.lots, response.data.data];
            this.setLots(newLots);
        } catch (e: any) {
            this.setError(e.response?.data?.message)
        } finally {
            this.setLoading(false)
        }
    }

    async updateLot(id: string, data: {
        name: string,
        description: string,
        price: string
    }) {
        this.setLoading(true)
        try {
            const response = await LotService.update(id, data);
            const updatedLots = this.lots.map(lot => {
                if (lot.id === id) {
                    return new Proxy(response.data.data, {});
                }
                return lot;
            });
            this.setLots(updatedLots)
        } catch (e: any) {
            this.setError(e.response?.data?.message)
        } finally {
            this.setLoading(false)
        }
    }

    async deleteLot(id: string) {
        this.setLoading(true)
        try {
            await LotService.delete(id);
            const lots = this.lots.filter(lot => lot.id !== id);
            this.setLots(lots)
        } catch (e: any) {
            this.setError('Deleting error')
        } finally {
            this.setLoading(false)
        }
    }

    async getLastWeekSum() {
        this.setLoading(true)
        try {
            const response = await StatisticsService.getLastWeekSumContributors();
            this.setLastWeekSum(response.data);
        } catch (e: any) {
            console.log(e)
        } finally {
            this.setLoading(false)
        }
    }

    async getLastWeekTransactions() {
        this.setLoading(true)
        try {
            const response = await StatisticsService.getLastWeekTransactionsContributors();
            this.setLastWeekTransactions(response.data);
        } catch (e: any) {
            console.log(e)
        } finally {
            this.setLoading(false)
        }
    }

}