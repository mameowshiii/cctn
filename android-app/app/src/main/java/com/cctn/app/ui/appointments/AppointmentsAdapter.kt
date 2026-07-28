package com.cctn.app.ui.appointments

import android.view.LayoutInflater
import android.view.ViewGroup
import androidx.core.content.ContextCompat
import androidx.recyclerview.widget.DiffUtil
import androidx.recyclerview.widget.ListAdapter
import androidx.recyclerview.widget.RecyclerView
import com.cctn.app.R
import com.cctn.app.data.model.AppointmentModel
import com.cctn.app.databinding.ItemAppointmentBinding

class AppointmentsAdapter(
    private val onCancelClick: (AppointmentModel) -> Unit
) : ListAdapter<AppointmentModel, AppointmentsAdapter.ViewHolder>(DiffCallback) {

    override fun onCreateViewHolder(parent: ViewGroup, viewType: Int): ViewHolder {
        val binding = ItemAppointmentBinding.inflate(
            LayoutInflater.from(parent.context), parent, false
        )
        return ViewHolder(binding)
    }

    override fun onBindViewHolder(holder: ViewHolder, position: Int) =
        holder.bind(getItem(position))

    inner class ViewHolder(private val b: ItemAppointmentBinding) :
        RecyclerView.ViewHolder(b.root) {

        fun bind(appt: AppointmentModel) {
            b.tvServiceName.text  = appt.service?.name ?: "Service"
            b.tvDate.text         = appt.preferredDate ?: "—"
            b.tvTime.text         = appt.preferredTime ?: "—"
            b.tvStatus.text       = appt.status.replaceFirstChar { it.uppercase() }

            val statusColor = when (appt.status) {
                "approved"  -> R.color.status_approved
                "pending"   -> R.color.status_pending
                "cancelled" -> R.color.status_cancelled
                else        -> R.color.status_pending
            }
            b.tvStatus.setTextColor(ContextCompat.getColor(b.root.context, statusColor))

            b.btnCancel.isEnabled = appt.status == "pending"
            b.btnCancel.setOnClickListener { onCancelClick(appt) }
        }
    }

    companion object DiffCallback : DiffUtil.ItemCallback<AppointmentModel>() {
        override fun areItemsTheSame(old: AppointmentModel, new: AppointmentModel) = old.id == new.id
        override fun areContentsTheSame(old: AppointmentModel, new: AppointmentModel) = old == new
    }
}
