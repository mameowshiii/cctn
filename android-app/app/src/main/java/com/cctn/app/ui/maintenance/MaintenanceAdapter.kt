package com.cctn.app.ui.maintenance

import android.view.LayoutInflater
import android.view.ViewGroup
import androidx.core.content.ContextCompat
import androidx.recyclerview.widget.DiffUtil
import androidx.recyclerview.widget.ListAdapter
import androidx.recyclerview.widget.RecyclerView
import com.cctn.app.R
import com.cctn.app.data.model.MaintenanceModel
import com.cctn.app.databinding.ItemMaintenanceBinding

class MaintenanceAdapter : ListAdapter<MaintenanceModel, MaintenanceAdapter.ViewHolder>(DiffCallback) {

    override fun onCreateViewHolder(parent: ViewGroup, viewType: Int): ViewHolder {
        val binding = ItemMaintenanceBinding.inflate(LayoutInflater.from(parent.context), parent, false)
        return ViewHolder(binding)
    }

    override fun onBindViewHolder(holder: ViewHolder, position: Int) = holder.bind(getItem(position))

    inner class ViewHolder(private val b: ItemMaintenanceBinding) : RecyclerView.ViewHolder(b.root) {
        fun bind(req: MaintenanceModel) {
            b.tvSubject.text    = req.subject
            b.tvPriority.text   = req.priority.replaceFirstChar { it.uppercase() }
            b.tvStatus.text     = req.status.replaceFirstChar { it.uppercase() }
            b.tvDescription.text = req.description ?: ""

            val statusColor = when (req.status.lowercase()) {
                "resolved" -> R.color.status_approved
                "pending"  -> R.color.status_pending
                else       -> R.color.status_pending
            }
            b.tvStatus.setTextColor(ContextCompat.getColor(b.root.context, statusColor))

            val priorityColor = when (req.priority.lowercase()) {
                "high"   -> R.color.status_cancelled
                "medium" -> R.color.status_pending
                else     -> R.color.on_surface_variant
            }
            b.tvPriority.setTextColor(ContextCompat.getColor(b.root.context, priorityColor))
        }
    }

    companion object DiffCallback : DiffUtil.ItemCallback<MaintenanceModel>() {
        override fun areItemsTheSame(old: MaintenanceModel, new: MaintenanceModel) = old.id == new.id
        override fun areContentsTheSame(old: MaintenanceModel, new: MaintenanceModel) = old == new
    }
}
