import {ILastWeekSum} from "../models/ILastWeekSum";
import {makeAutoObservable} from "mobx";
import StatisticsService from "../services/StatisticsService";
import {ILastWeekTransactions} from "../models/ILastWeekTransactions";


export default class StatisticsOrganization {

    lastWeekSum!: ILastWeekSum[];
    lastWeekTransactions!: ILastWeekTransactions[];
    isLoading = false;

    constructor() {
        makeAutoObservable(this)
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