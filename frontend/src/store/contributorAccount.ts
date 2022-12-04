import {ILastMonthContributorDonates} from "../models/ILastMonthContributorDonates";
import {makeAutoObservable} from "mobx";
import StatisticsService from "../services/StatisticsService";
import {IMostDonatedOrganizations} from "../models/IMostDonatedOrganizations";


export default class ContributorAccount {

    lastMonthDonates!: ILastMonthContributorDonates[];
    mostDonatedOrganizations!: IMostDonatedOrganizations[];
    averagePerMonth: any = 0;
    isLoading = false;

    constructor() {
        makeAutoObservable(this)
    }

    setLastMonthDonates(lastMonthDonates: ILastMonthContributorDonates[]) {
        this.lastMonthDonates = lastMonthDonates
    }

    setMostDonatedOrganizations(mostDonatedOrganizations: IMostDonatedOrganizations[]) {
        this.mostDonatedOrganizations = mostDonatedOrganizations
    }

    setAveragePerMonth(averagePerMonth: string) {
        this.averagePerMonth = averagePerMonth
    }

    setLoading(bool: boolean) {
        this.isLoading = bool;
    }

    async getLastMonthDonates() {
        this.setLoading(true)
        try {
            const response = await StatisticsService.getLastMonthContributorDonates();
            this.setLastMonthDonates(response.data.data);
        } catch (e: any) {
            console.log(e)
        } finally {
            this.setLoading(false)
        }
    }

    async getMostDonatedOrganizations() {
        this.setLoading(true)
        try {
            const response = await StatisticsService.getMostDonatedContributorCompanies();
            this.setMostDonatedOrganizations(response.data);
        } catch (e: any) {
            console.log(e)
        } finally {
            this.setLoading(false)
        }
    }

    async getAveragePerMonth() {
        this.setLoading(true)
        try {
            const response = await StatisticsService.getAveragePerMonth();
            this.setAveragePerMonth(response.data);
        } catch (e: any) {
            console.log(e)
        } finally {
            this.setLoading(false)
        }
    }

}