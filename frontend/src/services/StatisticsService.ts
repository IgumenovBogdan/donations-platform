import $api from "../http";
import {ILastWeekSum} from "../models/ILastWeekSum";
import {ILastWeekTransactions} from "../models/ILastWeekTransactions";
import {ILastMonthContributorDonates} from "../models/ILastMonthContributorDonates";
import {IMostDonatedOrganizations} from "../models/IMostDonatedOrganizations";

interface LastMonthContributorDonatesResponse {
    data: ILastMonthContributorDonates[]
}

export default class StatisticsService {
    static async getLastWeekSumContributors() {
        return $api.get<ILastWeekSum[]>('/organization/last-week-sum')
    }

    static async getLastWeekTransactionsContributors() {
        return $api.get<ILastWeekTransactions[]>('/organization/last-week-transactions')
    }

    static async getLastMonthContributorDonates() {
        return $api.get<LastMonthContributorDonatesResponse>('/contributor/last-month')
    }

    static async getMostDonatedContributorCompanies() {
        return $api.get<IMostDonatedOrganizations[]>('/contributor/most-donated')
    }

    static async getAveragePerMonth() {
        return $api.get('/contributor/average')
    }
}