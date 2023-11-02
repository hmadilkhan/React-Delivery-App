import React, { Component } from "react";
import Moment from "react-moment";

class EarningDetails extends Component {
	render() {
		const { transaction } = this.props;
		console.log("Trans",transaction);
		return (
			<React.Fragment>
				<div className="delivery-account-orders-block p-15 mb-20">
					<div className="d-flex justify-content-between mb-2">
						<div>
							<h4
								className={`mb-0 ${
									localStorage.getItem("deliveryAppLightMode") === "true" ? "text-dark" : "text-white"
								}`}
							>
								{localStorage.getItem("currencySymbolAlign") === "left" &&
									localStorage.getItem("currencyFormat")}
								{" "+transaction.order.total_amount}
								{localStorage.getItem("currencySymbolAlign") === "right" &&
									localStorage.getItem("currencyFormat")}
							</h4>
						</div>
						<div>
							{localStorage.getItem("showFromNowDate") === "true" ? (
								<Moment fromNow>{transaction.date}</Moment>
							) : (
								<Moment format="DD/MM/YYYY hh:mma">{transaction.order.date}</Moment>
							)}
						</div>
					</div>

					<div className="mb-2 float-right">
						{transaction.order.type === "deposit" && (
							<span className="btn btn-sm delivery-wallet-deposit min-width-125">
								{localStorage.getItem("walletDepositText")}
							</span>
						)}
						{transaction.order.type === "withdraw" && (
							<span className="btn btn-sm delivery-wallet-withdraw min-width-125">
								{localStorage.getItem("walletWithdrawText")}
							</span>
						)}
					</div>

					<div>{transaction.order.receipt_no}</div>
				</div>
			</React.Fragment>
		);
	}
}

export default EarningDetails;
