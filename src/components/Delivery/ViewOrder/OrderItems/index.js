import React, { Component } from "react";

class OrderInfo extends Component {
	render() {
		const item = this.props.item;
		return (
			<React.Fragment>
				<div className="d-flex justify-content-between">
					<div>
						<span className="delivery-order-item-quantity">{item.total_qty}x</span>
					</div>
					<div style={{ maxWidth: "200px", minWidth: "200px" }}>
						<strong>{item.item_name}</strong>
					</div>

					{localStorage.getItem("showPriceAndOrderCommentsDelivery") === "true" && (
						<div className="cart-item-price">
							<React.Fragment>
								{localStorage.getItem("currencySymbolAlign") === "left" &&
									localStorage.getItem("currencyFormat")}
								{item.item_price * item.total_qty}
								{localStorage.getItem("currencySymbolAlign") === "right" &&
									localStorage.getItem("currencyFormat")}
							</React.Fragment>
						</div>
					)}
				</div>
				{localStorage.getItem("showOrderAddonsDelivery") === "true" && (
					<div className="delivery-items-addons-block">
						{item && item.order_item_addons &&
							item.order_item_addons.map((addonArray, index) => (
								<React.Fragment key={item.id + addonArray.id + index}>
									<div className="d-flex justify-content-between">
										<div>{addonArray.addon_name}</div>
										<div>
											{localStorage.getItem("showPriceAndOrderCommentsDelivery") === "true" && (
												<React.Fragment>
													{localStorage.getItem("currencySymbolAlign") === "left" &&
														localStorage.getItem("currencyFormat")}{" "}
													{addonArray.addon_price}
													{localStorage.getItem("currencySymbolAlign") === "right" &&
														localStorage.getItem("currencyFormat")}
												</React.Fragment>
											)}
										</div>
									</div>
								</React.Fragment>
							))}
					</div>
				)}
				<hr className="single-item-division-hr" />
			</React.Fragment>
		);
	}
}

export default OrderInfo;
