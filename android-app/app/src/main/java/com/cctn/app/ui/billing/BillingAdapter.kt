package com.cctn.app.ui.billing

import android.view.LayoutInflater
import android.view.ViewGroup
import androidx.core.content.ContextCompat
import androidx.recyclerview.widget.DiffUtil
import androidx.recyclerview.widget.ListAdapter
import androidx.recyclerview.widget.RecyclerView
import com.cctn.app.R
import com.cctn.app.data.model.BillingModel
import com.cctn.app.databinding.ItemBillingBinding

class BillingAdapter : ListAdapter<BillingModel, BillingAdapter.ViewHolder>(DiffCallback) {

    override fun onCreateViewHolder(parent: ViewGroup, viewType: Int): ViewHolder {
        val binding = ItemBillingBinding.inflate(LayoutInflater.from(parent.context), parent, false)
        return ViewHolder(binding)
    }

    override fun onBindViewHolder(holder: ViewHolder, position: Int) = holder.bind(getItem(position))

    inner class ViewHolder(private val b: ItemBillingBinding) : RecyclerView.ViewHolder(b.root) {
        fun bind(bill: BillingModel) {
            b.tvPeriod.text    = bill.statementPeriod ?: "Statement"
            b.tvDueDate.text   = "Due: ${bill.dueDate ?: "—"}"
            b.tvAmount.text    = "₱${String.format("%.2f", bill.totalAmountDue)}"
            b.tvStatus.text    = bill.status.replaceFirstChar { it.uppercase() }

            val statusColor = when (bill.status.lowercase()) {
                "paid"    -> R.color.status_approved
                "overdue" -> R.color.status_cancelled
                else      -> R.color.status_pending
            }
            b.tvStatus.setTextColor(ContextCompat.getColor(b.root.context, statusColor))
        }
    }

    companion object DiffCallback : DiffUtil.ItemCallback<BillingModel>() {
        override fun areItemsTheSame(old: BillingModel, new: BillingModel) = old.id == new.id
        override fun areContentsTheSame(old: BillingModel, new: BillingModel) = old == new
    }
}
